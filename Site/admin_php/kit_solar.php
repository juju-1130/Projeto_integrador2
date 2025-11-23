<?php 
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header('Location: /login.php');
    exit();
}

include_once '../conexao.php';

if (!isset($conn) || $conn->connect_error) {
    die("Erro: Não foi possível conectar ao banco de dados.");
}

// Verificar se está no modo de edição
$modo_edicao = isset($_GET['editar']) && $_GET['editar'] == '1';

// Busca os valores
$sql = "SELECT chave, valor FROM config_custos_kit";
$result = $conn->query($sql);

$valores = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $valores[$row['chave']] = $row['valor'];
    }
}

// Processar atualização se estiver no modo de edição e foi submetido o form
if ($modo_edicao && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $chave => $valor) {
        if (strpos($chave, 'valor_') === 0) {
            $chave_real = substr($chave, 6); // Remove "valor_"
            $valor_float = floatval(str_replace(['.', ','], ['', '.'], $valor));
            
            $update = "UPDATE config_custos_kit SET valor = ? WHERE chave = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("ds", $valor_float, $chave_real);
            $stmt->execute();
        }
    }
    
    // Redireciona para sair do modo de edição
    header('Location: kit_solar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
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
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cog text-primary me-2"></i>
                    <h5 class="card-title mb-0">Custos Globais do Sistema</h5>
                </div>
                <div>
                    <?php if (!$modo_edicao): ?>
                        <a href="kit_solar.php?editar=1" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Modo Edição
                        </a>
                    <?php else: ?>
                        <button type="submit" form="formEdicao" class="btn btn-success btn-sm">
                            <i class="fas fa-save me-1"></i>Salvar Alterações
                        </button>
                        <a href="kit_solar.php" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <form method="POST" id="formEdicao">
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 table-hover align-middle">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th width="60%">Descrição</th>
                                <th width="25%">Valor</th>
                                <th width="15%">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $itens = [
                                ['mao_obra_por_placa', 'Custo mão de obra por placa', 'mao_obra'],
                                ['custo_cabos', 'Custo cabos', 'cabos'],
                                ['custo_conectores', 'Custo conectores', 'conectores'],
                                ['custos_fixos', 'Custos fixos', 'custos_fixos'],
                                ['porcentagem_comissao', 'Porcentagem Comissão', 'comissao']
                            ];
                            foreach ($itens as $item):
                                [$chave, $descricao, $tipo] = $item;
                                $valor = $valores[$chave] ?? 0;
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($descricao) ?></strong></td>
                                <td class="text-end">
                                    <?php if ($modo_edicao): ?>
                                        <div class="input-group input-group-sm">
                                            <?php if ($chave === 'porcentagem_comissao'): ?>
                                                <input type="text" 
                                                       name="valor_<?= $chave ?>" 
                                                       class="form-control text-end" 
                                                       value="<?= number_format($valor, 2, ',', '.') ?>"
                                                       required>
                                                <span class="input-group-text">%</span>
                                            <?php else: ?>
                                                <span class="input-group-text">R$</span>
                                                <input type="text" 
                                                       name="valor_<?= $chave ?>" 
                                                       class="form-control text-end" 
                                                       value="<?= number_format($valor, 2, ',', '.') ?>"
                                                       required>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($chave === 'porcentagem_comissao'): ?>
                                            <?= number_format($valor, 2, ',', '.') ?>%
                                        <?php else: ?>
                                            R$ <?= number_format($valor, 2, ',', '.') ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!$modo_edicao): ?>
                                        <a href="kit_solar.php?editar=1#<?= $chave ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="fas fa-edit text-success"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            
            <div class="card-footer text-muted text-end">
                <small>Última atualização: <?= date('d/m/Y H:i:s') ?></small>
                <?php if ($modo_edicao): ?>
                    <div class="mt-1">
                        <small class="text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Modo de edição ativo
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if ($modo_edicao): ?>
    <script>
        // Foca no primeiro campo quando entrar no modo de edição
        document.addEventListener('DOMContentLoaded', function() {
            const primeiroInput = document.querySelector('input[type="text"]');
            if (primeiroInput) {
                primeiroInput.focus();
                primeiroInput.select();
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>