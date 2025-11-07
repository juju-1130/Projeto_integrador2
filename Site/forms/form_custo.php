<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header('Location: /login.php');
    exit();
}

include_once '../conexao.php';

$tipo = $_GET['tipo'] ?? '';

$mapa = [
    'mao_obra' => ['mao_obra_por_placa', 'Custo Mão de Obra por Placa'],
    'cabos' => ['custo_cabos', 'Custo Cabos'],
    'trilho' => ['custo_trilho_por_placa', 'Custo Trilho por Placa'],
    'conectores' => ['custo_conectores', 'Custo Conectores'],
    'custos_fixos' => ['custos_fixos', 'Custos Fixos'],
    'custos_extras' => ['custos_extras', 'Custos Extras']
];

if (!isset($mapa[$tipo])) {
    die("Tipo inválido.");
}

list($chave, $titulo) = $mapa[$tipo];

// Buscar valor atual
$sql = "SELECT valor FROM config_custos_kit WHERE chave = '$chave'";
$result = $conn->query($sql);
$valor_atual = 0;
if ($result && $row = $result->fetch_assoc()) {
    $valor_atual = $row['valor'];
} else {
    $conn->query("INSERT INTO config_custos_kit (chave, valor) VALUES ('$chave', 0)");
}

// Atualizar valor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_valor = floatval($_POST['valor'] ?? 0);
    $update = "UPDATE config_custos_kit SET valor = '$novo_valor' WHERE chave = '$chave'";
    if ($conn->query($update)) {
        echo "<script>alert('✅ Valor atualizado com sucesso!'); window.top.location.href='../admin_php/kit_solar.php';</script>";
    } else {
        echo "<script>alert('❌ Erro ao atualizar valor!');</script>";
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <h4><?= $titulo ?></h4>
        <p>Valor atual: <strong>R$ <?= number_format($valor_atual, 2, ',', '.') ?></strong></p>
        <form method="POST">
            <div class="mb-3">
                <label for="valor" class="form-label">Novo Valor (R$):</label>
                <input type="number" step="0.01" name="valor" id="valor" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
