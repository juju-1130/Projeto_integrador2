<?php
/**
 * calculo_orcamento.php - VERSÃO CORRIGIDA COM GERAÇÃO DESEJADA
 */

define('DEFAULT_PANEL_WATT', 610);
define('EXTRA_KW_DEFAULT', 0.1);
define('HORAS_PICO_DIARIAS', 4.5);
define('DIAS_MES', 30.42);

function calcular_orcamento_integrado($conn, $consumo_mensal_medio_kwh, $opcoes = []){
    $extra_kw = isset($opcoes['extra_kw']) ? floatval($opcoes['extra_kw']) : EXTRA_KW_DEFAULT;
    $marca_inversor = isset($opcoes['marca_inversor']) ? $opcoes['marca_inversor'] : null;
    $placa_id = isset($opcoes['placa_id']) ? intval($opcoes['placa_id']) : null;
    $telhado_id = isset($opcoes['telhado_id']) ? intval($opcoes['telhado_id']) : null;
    $comissao_override = isset($opcoes['comissao_percent']) ? floatval($opcoes['comissao_percent']) : null;
    $geracao_desejada_kwh = isset($opcoes['geracao_desejada_kwh']) ? floatval($opcoes['geracao_desejada_kwh']) : null;
    $margem_seguranca = isset($opcoes['margem_seguranca']) ? floatval($opcoes['margem_seguranca']) : 0.1;

    // 1) CÁLCULO DA POTÊNCIA DO SISTEMA - CORRIGIDO
    $horas_sol_dia = HORAS_PICO_DIARIAS;
    $dias_mes = DIAS_MES;
    
    if ($geracao_desejada_kwh !== null) {
        // CORREÇÃO: Usa a geração desejada como base principal
        // Aplica margem de segurança à geração desejada
        $geracao_com_margem = $geracao_desejada_kwh * (1 + $margem_seguranca);
        
        // Potência do sistema em kWp = Geração desejada com margem / (horas_sol * dias_mes)
        $potencia_sistema_kwp = $geracao_com_margem / ($horas_sol_dia * $dias_mes);
        
    } else {
        // Modo normal - cálculo baseado no consumo
        $potencia_sistema_kwp = $consumo_mensal_medio_kwh / ($horas_sol_dia * $dias_mes);
        $potencia_sistema_kwp += $extra_kw;
    }
    
    $potencia_sistema_w = $potencia_sistema_kwp * 1000;

    // 2) BUSCAR DADOS DA PLACA
    $placa = buscar_placa_padrao($conn, $placa_id);
    if(!$placa) {
        throw new Exception('Nenhuma placa encontrada no banco.');
    }
    
    $panel_watt = floatval($placa['potencia_placa']);
    $preco_placa_unit = floatval($placa['valor_placa']);

    // 3) NÚMERO DE PLACAS (arredondar para cima)
    $quantidade_placas = (int) ceil($potencia_sistema_w / $panel_watt);
    $potencia_dc_total_w = $quantidade_placas * $panel_watt;
    $potencia_dc_total_kw = $potencia_dc_total_w / 1000;

    // 4) CÁLCULO DA PRODUÇÃO ESTIMADA - SEMPRE baseada na potência real do sistema
    $producao_estimada_mensal = $potencia_dc_total_kw * $horas_sol_dia * $dias_mes;

    // Se estamos no modo de geração desejada, ajustamos a produção para refletir o objetivo
    if ($geracao_desejada_kwh !== null) {
        // Mantemos a produção calculada, mas garantimos que atenda pelo menos a geração desejada
        $producao_estimada_mensal = max($producao_estimada_mensal, $geracao_desejada_kwh);
    }

    // 5) CÁLCULO DE MATERIAIS
    $unidades_cabo = (int) ceil($quantidade_placas / 2.0);
    $unidades_conector = (int) ceil($quantidade_placas / 4.0);
    $unidades_estrutura = $quantidade_placas;

    // 6) PREÇOS DE CUSTOS
    $preco_cabo = buscar_config_valor($conn, 'custo_cabos');
    $preco_conector = buscar_config_valor($conn, 'custo_conectores');
    $preco_mao_obra_por_placa = buscar_config_valor($conn, 'mao_obra_por_placa');
    $custos_fixos = buscar_config_valor($conn, 'custos_fixos');
    $porcentagem_comissao_config = buscar_config_valor($conn, 'porcentagem_comissao');

    $comissao_percent = ($comissao_override !== null) ? $comissao_override : floatval($porcentagem_comissao_config);
    if($comissao_percent > 1.0) $comissao_percent = $comissao_percent / 100.0;

    // 7) PREÇO DA ESTRUTURA
    $preco_estrutura_por_placa = buscar_valor_telhado_por_placa($conn, $telhado_id);

    // 8) SELEÇÃO DO INVERSOR
    $inversores = buscar_inversores($conn, $marca_inversor);
    
    $opcoes_viaveis = [];
    foreach($inversores as $inv){
        $potencia_inv_w = floatval($inv['potencia_inversor']) * 1000.0;
        
        // Critério: potência DC total não deve exceder 130% da potência do inversor
        $limite_maximo_dc = $potencia_inv_w * 1.3;
        
        if($potencia_dc_total_w <= $limite_maximo_dc){
            $opcoes_viaveis[] = $inv;
        }
    }

    // Ordenar por potência ascendente
    usort($opcoes_viaveis, function($a,$b){
        return floatval($a['potencia_inversor']) <=> floatval($b['potencia_inversor']);
    });

    // Selecionar o melhor inversor (menor que atenda)
    $melhor_inversor = count($opcoes_viaveis) ? $opcoes_viaveis[0] : null;
    $preco_inversor = $melhor_inversor ? floatval($melhor_inversor['valor_inversor']) : 0.0;
    $inversor_id = $melhor_inversor ? intval($melhor_inversor['inversor_id']) : null;

    // 9) CÁLCULO DE CUSTOS
    $custo_paineis_total = $quantidade_placas * $preco_placa_unit;
    $custo_cabos = $unidades_cabo * floatval($preco_cabo);
    $custo_conectores = $unidades_conector * floatval($preco_conector);
    $custo_estrutura = $unidades_estrutura * floatval($preco_estrutura_por_placa);
    $custo_mao_obra = $quantidade_placas * floatval($preco_mao_obra_por_placa);

    $subtotal = $custo_paineis_total + $preco_inversor + $custo_cabos + 
                $custo_conectores + $custo_estrutura + $custo_mao_obra + 
                floatval($custos_fixos);

    $comissao_valor = $subtotal * floatval($comissao_percent);
    $total = $subtotal + $comissao_valor;

    // Montar resultado
    $resultado = [
        'entrada' => [
            'consumo_mensal_medio_kwh' => $consumo_mensal_medio_kwh,
            'geracao_desejada_kwh' => $geracao_desejada_kwh,
            'margem_seguranca' => $margem_seguranca,
            'potencia_sistema_kwp' => $potencia_sistema_kwp,
            'potencia_sistema_w' => $potencia_sistema_w,
            'panel_watt' => $panel_watt,
            'quantidade_placas' => $quantidade_placas,
            'potencia_dc_total_w' => $potencia_dc_total_w,
            'potencia_dc_total_kw' => $potencia_dc_total_kw,
            'producao_estimada_mensal' => $producao_estimada_mensal
        ],
        'materiais' => [
            'cabos_unidades' => $unidades_cabo,
            'conectores_unidades' => $unidades_conector,
            'estrutura_unidades' => $unidades_estrutura,
            'mao_obra_por_placa' => floatval($preco_mao_obra_por_placa)
        ],
        'precos_unitarios' => [
            'preco_painel_unit' => $preco_placa_unit,
            'preco_inversor_unit' => $preco_inversor,
            'preco_cabo_unit' => floatval($preco_cabo),
            'preco_conector_unit' => floatval($preco_conector),
            'preco_estrutura_por_placa' => floatval($preco_estrutura_por_placa),
            'custos_fixos' => floatval($custos_fixos),
            'porcentagem_comissao' => $comissao_percent
        ],
        'custos' => [
            'custo_paineis_total' => $custo_paineis_total,
            'custo_inversor' => $preco_inversor,
            'custo_cabos' => $custo_cabos,
            'custo_conectores' => $custo_conectores,
            'custo_estrutura' => $custo_estrutura,
            'custo_mao_obra' => $custo_mao_obra,
            'custos_fixos' => floatval($custos_fixos),
            'subtotal' => $subtotal,
            'comissao_valor' => $comissao_valor,
            'total' => $total
        ],
        'melhor_inversor' => $melhor_inversor,
        'inversor_id' => $inversor_id
    ];

    return $resultado;
}

// Funções helper (mantenha as existentes)
function buscar_placa_padrao($conn, $placa_id = null){
    if($placa_id){
        $sql = "SELECT placa_id, marca_placa, potencia_placa, valor_placa FROM Placa WHERE placa_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if(!$stmt) return null;
        $stmt->bind_param('i', $placa_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc() ?: null;
    }
    $r = $conn->query("SELECT placa_id, marca_placa, potencia_placa, valor_placa FROM Placa LIMIT 1");
    if($r && $r->num_rows) return $r->fetch_assoc();
    return null;
}

function buscar_inversores($conn, $marca_inversor = null){
    if($marca_inversor){
        $sql = "SELECT inversor_id, marca_inversor, potencia_inversor, overload, entradas, mppt, valor_inversor, nome_inversor FROM Inversor WHERE marca_inversor = ? ORDER BY potencia_inversor ASC";
        $stmt = $conn->prepare($sql);
        if(!$stmt) return [];
        $stmt->bind_param('s', $marca_inversor);
        $stmt->execute();
        $res = $stmt->get_result();
    } else {
        $res = $conn->query("SELECT inversor_id, marca_inversor, potencia_inversor, overload, entradas, mppt, valor_inversor, nome_inversor FROM Inversor ORDER BY potencia_inversor ASC");
    }
    $arr = [];
    if($res){
        while($row = $res->fetch_assoc()) $arr[] = $row;
    }
    return $arr;
}

function buscar_config_valor($conn, $chave){
    $sql = "SELECT valor FROM config_custos_kit WHERE chave = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if(!$stmt) return 0.0;
    $stmt->bind_param('s', $chave);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    return $row ? floatval($row['valor']) : 0.0;
}

function buscar_valor_telhado_por_placa($conn, $telhado_id = null){
    if($telhado_id){
        $sql = "SELECT valor FROM Telhado WHERE telhado_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if(!$stmt) return 0.0;
        $stmt->bind_param('i', $telhado_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if($row) return floatval($row['valor']);
    }
    $r = $conn->query("SELECT valor FROM Telhado LIMIT 1");
    if($r && $r->num_rows) {
        $row = $r->fetch_assoc();
        return floatval($row['valor']);
    }
    return 0.0;
}
?>