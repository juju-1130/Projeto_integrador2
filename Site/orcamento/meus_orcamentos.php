<?php
session_start();
include_once "../conexao.php";

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM Orcamento WHERE usuario_id = ? ORDER BY data_criacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php include __DIR__ . '/../head.php'; ?>
<body id="page-top">
    <!-- Navigation-->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Meus Orçamentos"); ?>


    <!-- Seção Lista de Orçamentos -->
    <section class="page-section" id="meus-orcamentos" style="padding: 60px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card shadow orcamento-card">
                        <div class="card-body p-4">
                            <?php if ($result->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-white">
                                            <tr>
                                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                                <th><i class="fas fa-calendar me-2"></i>Data</th>
                                                <th><i class="fas fa-bolt me-2"></i>Potência (kWp)</th>
                                                <th><i class="fas fa-solar-panel me-2"></i>Placas</th>
                                                <th><i class="fas fa-dollar-sign me-2"></i>Valor Total</th>
                                                <th><i class="fas fa-cogs me-2"></i>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($o = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="fw-bold">#<?= $o['orcamento_id'] ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($o['data_criacao'])) ?></td>
                                                    <td>
                                                        <span class="badge bg-primary fs-6">
                                                            <?= number_format($o['potencia_sistema_kwp'], 2, ',', '.') ?> kWp
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info text-dark fs-6">
                                                            <?= $o['quantidade_placas'] ?> unidades
                                                        </span>
                                                    </td>
                                                    <td class="fw-bold text-success fs-5">
                                                        R$ <?= number_format(floatval($o['valor_total_final']), 2, ',', '.') ?>
                                                    </td>
                                                    <td>
                                                        <a href="gerar_pdf.php?id=<?= $o['orcamento_id'] ?>" target="_blank" class="btn-pdf">
                                                            <i class="fas fa-file-pdf me-2"></i>Ver PDF
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <h3 class="text-muted">Nenhum orçamento encontrado</h3>
                                    <p class="text-muted mb-4">Você ainda não possui orçamentos gerados.</p>
                                    <a href="orcamento.php" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calculator me-2"></i>Criar Primeiro Orçamento
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($result->num_rows > 0): ?>
                    <div class="text-center mt-4">
                        <a href="../contato.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>Solicitar Visita Técnica
                        </a>
                        <a href="../orcamento.php" class="btn btn-outline-primary btn-lg ms-2">
                            <i class="fas fa-plus me-2"></i>Novo Orçamento
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>
</html>