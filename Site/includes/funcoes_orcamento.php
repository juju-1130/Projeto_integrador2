<?php
function calcular_orcamento($conn, $consumos, $tarifa, $potencia_placa) {
    // Converte todos os consumos para float
    $consumos_float = array_map('floatval', $consumos);
    
    // Média do consumo
    $consumo_mensal_medio = array_sum($consumos_float) / count($consumos_float);

    // Busca custos fixos do banco
    $custos = [];
    $sql = "SELECT chave, valor FROM config_custos_kit";
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $custos[$row['chave']] = (float)$row['valor'];
        }
    }
    
    // Valores padrão caso não encontre no banco
    $custos_default = [
        'custo_trilho_por_placa' => 50,
        'mao_obra_por_placa' => 100,
        'custo_cabos' => 200,
        'custo_conectores' => 150,
        'custos_fixos' => 800,
        'custos_extras' => 300
    ];
    
    $custos = array_merge($custos_default, $custos);

    // HSP médio (horas de sol pleno / dia)
    $hsp = 4.5;

    // Potência do sistema (kWp)
    $potencia_kwp = ($consumo_mensal_medio / ($hsp * 30)) / 0.8;

    // Quantidade de placas
    $qtd_placas = ceil(($potencia_kwp * 1000) / $potencia_placa);

    // Recalcula a potência real baseada na quantidade de placas
    $potencia_kwp_real = ($qtd_placas * $potencia_placa) / 1000;

    // Calcula potência mínima do inversor (80% da potência do sistema)
    $potencia_inversor_minima = $potencia_kwp_real * 0.8;

    // Projeção de produção mensal (kWh)
    $producao_mensal_estimada = $potencia_kwp_real * $hsp * 30 * 0.8;

    // Custos totais
    $custo_placas = $qtd_placas * ($custos['custo_trilho_por_placa'] + $custos['mao_obra_por_placa']);
    $valor_total_custo = $custo_placas + $custos['custo_cabos'] + $custos['custo_conectores'] + $custos['custos_fixos'] + $custos['custos_extras'];

    // Margem de lucro
    $margem = 0.25;
    $valor_total_final = $valor_total_custo * (1 + $margem);

    return [
        'consumo_mensal_medio' => round($consumo_mensal_medio, 2),
        'potencia_sistema_kwp' => round($potencia_kwp_real, 2),
        'quantidade_placas' => $qtd_placas,
        'valor_total_custo' => round($valor_total_custo, 2),
        'margem_aplicada' => $margem,
        'valor_total_final' => round($valor_total_final, 2),
        'potencia_inversor_minima' => round($potencia_inversor_minima, 2),
        'producao_mensal_estimada' => round($producao_mensal_estimada, 2),
        'economia_mensal_estimada' => round($producao_mensal_estimada * $tarifa, 2)
    ];
}
?>