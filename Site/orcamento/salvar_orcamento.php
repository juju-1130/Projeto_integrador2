<?php
session_start();
include '../conexao.php';
include 'calculo_orcamento.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../autenticacao/login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ====== DADOS DO FORMULÁRIO ======
    $modo_rapido = isset($_POST['modo_rapido']) ? (int)$_POST['modo_rapido'] : 0;
    $cidade_cliente = isset($_POST['cidade_cliente']) ? trim($_POST['cidade_cliente']) : ''; 
    $consumos = $_POST['consumo_mes'];
    $tarifa = isset($_POST['tarifa']) ? (float)$_POST['tarifa'] : 0.85;
    $telhado_id = (int)$_POST['telhado_id'];
    $fase_id = (int)$_POST['fase_id'];
    $concessionaria_id = (int)$_POST['concessionaria_id'];
    $placa_id = (int)$_POST['placa_id'];
    $marca_inversor = trim($_POST['marca_inversor']);
    $tipo_instalacao = trim($_POST['tipo_instalacao']);
    $observacoes = trim($_POST['observacoes'] ?? '');

    // ====== VALIDAÇÃO BÁSICA ======
    if (empty($cidade_cliente)) {
        die("Erro: O campo cidade é obrigatório.");
    }

    // ====== CÁLCULO DO CONSUMO MÉDIO ======
    $consumo_mensal_medio_kwh = array_sum($consumos) / 12;

    // ====== PREPARAR OPÇÕES PARA O CÁLCULO ======
    $opcoes_calculo = [
        'placa_id' => $placa_id,
        'telhado_id' => $telhado_id,
        'marca_inversor' => $marca_inversor
    ];

    // ====== VERIFICAR SE OS CAMPOS DO MODO RÁPIDO EXISTEM ======
    $geracao_desejada = isset($_POST['geracao_desejada']) ? (float)$_POST['geracao_desejada'] : null;
    $margem_seguranca = isset($_POST['margem_seguranca']) ? (float)$_POST['margem_seguranca'] : null;

    // ====== SE MODO RÁPIDO ESTIVER ATIVO E CAMPOS EXISTIREM, USA GERAÇÃO DESEJADA ======
    if ($modo_rapido && $geracao_desejada !== null && $margem_seguranca !== null) {
        
        // CORREÇÃO: Passa a geração desejada e margem como opções
        $opcoes_calculo['geracao_desejada_kwh'] = $geracao_desejada;
        $opcoes_calculo['margem_seguranca'] = $margem_seguranca;
        $opcoes_calculo['extra_kw'] = 0; // No modo rápido, não adiciona extra

    } else {
        // Modo normal - cálculo baseado no consumo
        $opcoes_calculo['extra_kw'] = 0.1;
    }

    // ====== CHAMA O CÁLCULO PRINCIPAL ======
    $resultado = calcular_orcamento_integrado($conn, $consumo_mensal_medio_kwh, $opcoes_calculo);

    // ====== EXTRAI RESULTADOS ======
    $quantidade_placas = $resultado['entrada']['quantidade_placas'];
    $potencia_sistema_kwp = $resultado['entrada']['potencia_dc_total_kw'];
    $producao_estimada = $resultado['entrada']['producao_estimada_mensal'];
    $inversor_id = $resultado['inversor_id'];

    // economia estimada
    $economia_mensal = $producao_estimada * $tarifa;

    // custo total
    $valor_total_custo = $resultado['custos']['subtotal'];
    $valor_total_final = $resultado['custos']['total'];
    $margem_aplicada = $resultado['precos_unitarios']['porcentagem_comissao'];

    $json_consumo = json_encode($consumos);

    // ====== SALVAR NO BANCO ======
    $sql = "INSERT INTO Orcamento (
        usuario_id, cidade_cliente, consumo_mensal_medio, consumo_mensal_json,
        tarifa, potencia_sistema_kwp, quantidade_placas, valor_total_custo,
        margem_aplicada, tipo_instalacao, fase_id, concessionaria_id,
        placa_id, telhado_id, valor_total_final, inversor_id,
        producao_estimada, economia_mensal_estimada
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar SQL: " . $conn->error);
    }

    $stmt->bind_param(
        "isdsddidssiiiidddd",
        $usuario_id,
        $cidade_cliente,
        $consumo_mensal_medio_kwh,
        $json_consumo,
        $tarifa,
        $potencia_sistema_kwp,
        $quantidade_placas,
        $valor_total_custo,
        $margem_aplicada,
        $tipo_instalacao,
        $fase_id,
        $concessionaria_id,
        $placa_id,
        $telhado_id,
        $valor_total_final,
        $inversor_id,
        $producao_estimada,
        $economia_mensal
    );

    if ($stmt->execute()) {
        $orcamento_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        
        header("Location: gerar_pdf.php?id=$orcamento_id");
        exit();
        
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border: 2px solid #dc3545; margin: 10px 0;'>";
        echo "<h5 style='color: #721c24;'>❌ Erro ao salvar</h5>";
        echo "<strong>Erro:</strong> " . $stmt->error;
        echo "</div>";
        $stmt->close();
    }

    $conn->close();
}
?>