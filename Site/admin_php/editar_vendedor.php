<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/head.php'; ?>
    <body id="page-top">
        <!-- Navigation-->
        <?php 
        $pagina_parametros = [
            'editar_vendedor.php' => ['editar_dados'],
        ];
        include __DIR__ . '/../includes/navbar.php';
        ?>

        <!--Seção titulo-->
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Vendedores"); ?>

        <!-- Botão Novo Vendedor -->
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="editar_vendedor.php?modal=novo_vendedor" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Novo Vendedor
                </a>
            </div>
        </div>

        <!-- Seção Vendedores -->
        <section class="page-section py-5" id="vendedores">
            <div class="container">
                <div class="row g-4" id="vendedoresContainer">
                    <!-- Vendedor Jonathan -->
                    <div class="col-lg-4 col-md-6 vendedor-card">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    <img src="../images/icone.png" class="rounded-circle shadow" width="120" height="120">
                                </div>
                                <h4 class="card-title mb-2">Jonathan Kirsch</h4>
                                <p class="text-muted mb-3">Especialista em Energia Solar e CEO</p>
                                <p class="card-text mb-4">Atendimento personalizado para encontrar a melhor solução em energia solar para sua necessidade.</p>
                                <a href="https://wa.me/5551999999999?text=Olá Jonathan, gostaria de informações sobre energia solar" 
                                class="btn btn-success w-100" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Falar com Jonathan
                                </a>
                                <div class="mt-3">
                                    <a href="editar_vendedor.php?modal=editar_vendedor&id=1" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="editar_vendedor.php?modal=excluir_vendedor&id=1" class="btn btn-danger btn-sm">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vendedor Dhonavan -->
                    <div class="col-lg-4 col-md-6 vendedor-card">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    <img src="../images/icone.png" class="rounded-circle shadow" width="120" height="120">
                                </div>
                                <h4 class="card-title mb-2">Dhonavan Dias</h4>
                                <p class="text-muted mb-3">Consultor e Especialista em Energia Solar</p>
                                <p class="card-text mb-4">Especialista em projetos personalizados para maximizar sua economia com energia solar.</p>
                                <a href="https://wa.me/5551999999998?text=Olá Dhonavan, gostaria de informações sobre energia solar" 
                                class="btn btn-success w-100" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Falar com Dhonavan
                                </a>
                                <div class="mt-3">
                                    <a href="editar_vendedor.php?modal=editar_vendedor&id=2" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="editar_vendedor.php?modal=excluir_vendedor&id=2" class="btn btn-danger btn-sm">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vendedor MK -->
                    <div class="col-lg-4 col-md-6 vendedor-card">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    <img src="../images/icone.png" class="rounded-circle shadow" width="120" height="120">
                                </div>
                                <h4 class="card-title mb-2">MK Energia Solar</h4>
                                <p class="text-muted mb-3">Especialista em Garantir Maior Comodidade aos Clientes</p>
                                <p class="card-text mb-4">Empresa Especialista em Energia Solar</p>
                                <a href="https://wa.me/5551999999997?text=Olá MK, gostaria de informações sobre energia solar" 
                                class="btn btn-success w-100" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Falar com MK
                                </a>
                                <div class="mt-3">
                                    <a href="editar_vendedor.php?modal=editar_vendedor&id=3" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="editar_vendedor.php?modal=excluir_vendedor&id=3" class="btn btn-danger btn-sm">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php if (isset($_GET['modal'])): ?>
<div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; width: 80%; height: 80%; border-radius: 5px; position: relative;">
        <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
            <h5 class="m-0"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($_GET['modal']))); ?></h5>
            <a href="editar_vendedor.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
        </div>
        <iframe src="editar_iframe.php?tipo=<?php echo htmlspecialchars($_GET['modal']); ?><?php echo isset($_GET['id']) ? '&id=' . htmlspecialchars($_GET['id']) : ''; ?>" 
        style="width: 100%; height: calc(100% - 50px); border: none;"></iframe>
    </div>
</div>
<?php endif; ?>