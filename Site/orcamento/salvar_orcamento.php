<?php
session_start();
include '../conexao.php';
include '../includes/funcoes_orcamento.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../autenticacao/login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Coleta dados
    $cidade_cliente = trim($_POST['cidade_cliente']);
    $consumos = $_POST['consumo_mes'];
    $tarifa = isset($_POST['tarifa']) ? (float)$_POST['tarifa'] : 0.85;
    $telhado_id = (int)$_POST['telhado_id'];
    $fase_id = (int)$_POST['fase_id'];
    $concessionaria_id = (int)$_POST['concessionaria_id'];
    $inversor_id = (int)$_POST['inversor_id'];
    $placa_id = (int)$_POST['placa_id'];
    $tipo_instalacao = trim($_POST['tipo_instalacao']);
    $observacoes = trim($_POST['observacoes'] ?? '');

    // Busca a potência da placa
    $potencia_placa = 585;
    $sql_placa = "SELECT potencia_placa FROM Placa WHERE placa_id = ?";
    $stmt_placa = $conn->prepare($sql_placa);
    if ($stmt_placa) {
        $stmt_placa->bind_param("i", $placa_id);
        $stmt_placa->execute();
        $stmt_placa->bind_result($potencia_db);
        if ($stmt_placa->fetch()) {
            $potencia_placa = $potencia_db;
        }
        $stmt_placa->close();
    }

    // Cálculo do orçamento
    $resultado = calcular_orcamento($conn, $consumos, $tarifa, $potencia_placa);
    $json_consumo = json_encode($consumos);

    // EXTRAIR TODOS OS VALORES DO ARRAY PARA VARIÁVEIS SEPARADAS
    $consumo_medio = $resultado['consumo_mensal_medio'];
    $potencia_kwp = $resultado['potencia_sistema_kwp'];
    $qtd_placas = $resultado['quantidade_placas'];
    $valor_custo = $resultado['valor_total_custo'];
    $margem = (string)$resultado['margem_aplicada'];
    $valor_final = $resultado['valor_total_final'];
    $potencia_inversor = $resultado['potencia_inversor_minima'];
    $producao_estimada = $resultado['producao_mensal_estimada'];
    $economia_mensal = $resultado['economia_mensal_estimada'];

    // SQL com 19 campos
    $sql = "INSERT INTO Orcamento (
        usuario_id, cidade_cliente, consumo_mensal_medio, consumo_mensal_json,
        tarifa, potencia_sistema_kwp, quantidade_placas, valor_total_custo,
        margem_aplicada, tipo_instalacao, fase_id, concessionaria_id,
        inversor_id, placa_id, telhado_id, valor_total_final,
        potencia_inversor_minima, producao_estimada, economia_mensal_estimada
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // 19 tipos para 19 variáveis: isdsddidssiiiiidddd
        $stmt->bind_param(
            "isdsddidssiiiiidddd",
            $usuario_id,           // i (1)
            $cidade_cliente,       // s (2)
            $consumo_medio,        // d (3)
            $json_consumo,         // s (4)
            $tarifa,               // d (5)
            $potencia_kwp,         // d (6)
            $qtd_placas,           // i (7)
            $valor_custo,          // d (8)
            $margem,               // s (9)
            $tipo_instalacao,      // s (10)
            $fase_id,              // i (11)
            $concessionaria_id,    // i (12)
            $inversor_id,          // i (13)
            $placa_id,             // i (14)
            $telhado_id,           // i (15)
            $valor_final,          // d (16)
            $potencia_inversor,    // d (17)
            $producao_estimada,    // d (18)
            $economia_mensal       // d (19)
        );

        if ($stmt->execute()) {
            $orcamento_id = $stmt->insert_id;
            header("Location: gerar_pdf.php?id=$orcamento_id");
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro prepare: " . $conn->error;
    }
}
$conn->close();
?>