<?php 
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header('Location: /login.php');
    exit();
}

// Inclui a conexão com MySQLi
include_once '../conexao.php';

// Verifica a conexão
if (!isset($conn) || $conn->connect_error) {
    die("Erro: Não foi possível conectar ao banco de dados.");
}

// Busca os valores
$sql = "SELECT chave, valor FROM config_custos_kit";
$result = $conn->query($sql);

$valores = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $valores[$row['chave']] = $row['valor'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: 0.2s;
        }
        .modal-overlay {
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); 
            z-index: 1000; 
            display: flex; 
            justify-content: center; 
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }
        .modal-content {
            background: white; 
            width: 80%; 
            height: 80%; 
            border-radius: 8px; 
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            animation: scaleIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; } 
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; } 
            to { transform: scale(1); opacity: 1; }
        }
        .modal-header-custom {
            background-color: #0d6efd; 
            color: white; 
            padding: 10px 15px;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        .modal-header-custom h5 {
            margin: 0;
        }
        iframe {
            width: 100%; 
            height: calc(100% - 50px); 
            border: none;
        }
    </style>
</head>
<body id="page-top">
    <?php 
    $pagina_parametros = ['kit_solar.php' => ['editar_dados']];
    include __DIR__ . '/../includes/navbar.php';
    ?>
    
    <?php include __DIR__ . '/../includes/funcoes.php'; ?>
    <?php echo gerarTituloPagina("Configurações do Kit Solar"); ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="fas fa-cog text-primary me-2"></i>
                <h5 class="card-title mb-0">Custos Globais do Sistema</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 table-hover align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th width="60%">Descrição</th>
                            <th width="25%">Valor Atual</th>
                            <th width="15%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itens = [
                            ['mao_obra_por_placa', 'Custo mão de obra por placa', 'mao_obra'],
                            ['custo_cabos', 'Custo cabos', 'cabos'],
                            ['custo_trilho_por_placa', 'Custo trilho por placa', 'trilho'],
                            ['custo_conectores', 'Custo conectores', 'conectores'],
                            ['custos_fixos', 'Custos fixos', 'custos_fixos'],
                            ['custos_extras', 'Custos extras', 'custos_extras']
                        ];
                        foreach ($itens as $item):
                            [$chave, $descricao, $tipo] = $item;
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($descricao) ?></strong></td>
                            <td class="text-end">R$ <?= number_format($valores[$chave] ?? 0, 2, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="kit_solar.php?modal=<?= $tipo ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted text-end">
                <small>Última atualização: <?= date('d/m/Y H:i:s') ?></small>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <?php if (isset($_GET['modal'])): ?>
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5>Editar <?= ucfirst(htmlspecialchars($_GET['modal'])) ?></h5>
                <a href="kit_solar.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>
            <iframe src="../forms/form_custo.php?tipo=<?= htmlspecialchars($_GET['modal']) ?>"></iframe>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
