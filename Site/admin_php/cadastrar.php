<!DOCTYPE html>
<html lang="en">
    <?php include __DIR__ . '/head.php'; ?>
    <body id="page-top">
        <?php 
            $pagina_parametros = [
                'cadastrar.php' => ['editar_dados'],
            ];

            include __DIR__ . '/../includes/navbar.php';
        ?>
        <!--Seção titulo-->
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Projetos concluídos"); ?>

        <!-- Botão Novo Projeto -->
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="cadastrar.php?modal=novo" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Novo Projeto
                </a>
            </div>
        </div>

        <!-- Masthead-->
        <header>
        <!-- Seção de projetos-->
        <section class="page-section projects" id="projects">
            <div class="container">
                <!-- Projeto 1 -->
                <div class="project-card mb-5 p-4 rounded-3 bg-light">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-5 col-md-6">
                            <img src="../images/project1.png" class="img-fluid rounded shadow projeto-img" alt="Sistema solar residencial">
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="ps-lg-4">
                                <h3 class="project-title mb-3">Sistema solar de 6,27Kwp</h3>
                                <ul class="project-features list-unstyled">
                                    <li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Cidade de Rolante</li>
                                    <li class="mb-2"><i class="fas fa-solar-panel text-primary me-2"></i> 11 módulos de 570W</li>
                                    <li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i> Inversor Chint de 5Kw</li>
                                    <li class="mb-2"><i class="fas fa-battery-three-quarters text-primary me-2"></i> Economia: R$ 350/mês</li>
                                </ul>
                                <div class="project-meta mt-3 small text-muted">
                                    <span class="me-3"><i class="far fa-calendar-alt me-1"></i> Concluído: Jan/2023</span>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary me-2">Residencial</span>
                                    <span class="badge bg-success">Sustentável</span>
                                </div>
                                <div class="mt-4">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-warning btn-sm" onclick="destacarProjeto(this)" title="Destacar projeto">
                                            <i class="fas fa-star me-1"></i> Destacar
                                        </button>
                                        <a href="cadastrar.php?modal=editar_projeto&id=1" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="cadastrar.php?modal=excluir_projeto&id=1" class="btn btn-danger btn-sm">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Projeto 2 -->
                <div class="project-card mb-5 p-4 rounded-3 bg-light">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-5 col-md-6">
                            <img src="../images/project2.png" class="img-fluid rounded shadow projeto-img" alt="Sistema solar residencial">
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="ps-lg-4">
                                <h3 class="project-title mb-3">Sistema solar de 5,49Kwp</h3>
                                <ul class="project-features list-unstyled">
                                    <li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Cidade de Rolante</li>
                                    <li class="mb-2"><i class="fas fa-solar-panel text-primary me-2"></i> 9 módulos de 610W</li>
                                    <li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i> Inversor Chint de 5Kw</li>
                                    <li class="mb-2"><i class="fas fa-battery-three-quarters text-primary me-2"></i> Economia: R$ 350/mês</li>
                                </ul>
                                <div class="project-meta mt-3 small text-muted">
                                    <span class="me-3"><i class="far fa-calendar-alt me-1"></i> Concluído: Jan/2023</span>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary me-2">Residencial</span>
                                    <span class="badge bg-success">Sustentável</span>
                                </div>
                                <div class="mt-4">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-warning btn-sm" onclick="destacarProjeto(this)" title="Destacar projeto">
                                            <i class="fas fa-star me-1"></i> Destacar
                                        </button>
                                        <a href="cadastrar.php?modal=editar_projeto&id=2" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="cadastrar.php?modal=excluir_projeto&id=2" class="btn btn-danger btn-sm">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Projeto 3 -->
                <div class="project-card mb-5 p-4 rounded-3 bg-light">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-5 col-md-6">
                            <img src="../images/project3.jpg" class="img-fluid rounded shadow projeto-img" alt="Sistema solar residencial">
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="ps-lg-4">
                                <h3 class="project-title mb-3">Sistema solar de 5,13Kwp</h3>
                                <ul class="project-features list-unstyled">
                                    <li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Cidade de Rolante</li>
                                    <li class="mb-2"><i class="fas fa-solar-panel text-primary me-2"></i> 9 módulos de 570W</li>
                                    <li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i> Inversor Chint de 5Kw</li>
                                    <li class="mb-2"><i class="fas fa-battery-three-quarters text-primary me-2"></i> Economia: R$ 350/mês</li>
                                </ul>
                                <div class="project-meta mt-3 small text-muted">
                                    <span class="me-3"><i class="far fa-calendar-alt me-1"></i> Concluído: Jan/2023</span>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary me-2">Residencial</span>
                                    <span class="badge bg-success">Sustentável</span>
                                </div>
                                <div class="mt-4">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-warning btn-sm" onclick="destacarProjeto(this)" title="Destacar projeto">
                                            <i class="fas fa-star me-1"></i> Destacar
                                        </button>
                                        <a href="cadastrar.php?modal=editar_projeto&id=3" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="cadastrar.php?modal=excluir_projeto&id=3" class="btn btn-danger btn-sm">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End section projetos-->
        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
        function destacarProjeto(button) {
            const card = button.closest('.project-card');

            const titulo = card.querySelector('.project-title')?.innerText;
            const imagem = card.querySelector('img')?.getAttribute('src');
            const detalhes = card.querySelector('.project-features')?.innerHTML;
            const meta = card.querySelector('.project-meta')?.innerHTML;
            const tags = card.querySelectorAll('.badge');

            const novoProjeto = {
                titulo,
                imagem,
                detalhes,
                meta,
                tags: Array.from(tags).map(tag => tag.outerHTML)
            };

            const projetosDestacados = JSON.parse(localStorage.getItem('projetosDestacados')) || [];

            const LIMITE = 2;

            projetosDestacados.unshift(novoProjeto); 
            if (projetosDestacados.length > LIMITE) {
                projetosDestacados.pop(); 
            }

            localStorage.setItem('projetosDestacados', JSON.stringify(projetosDestacados));
            alert('Projeto destacado com sucesso!');
        }
        </script>
    </body>
</html>

<?php if (isset($_GET['modal'])): ?>
<div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; width: 80%; height: 80%; border-radius: 5px; position: relative;">
        <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
            <h5 class="m-0"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($_GET['modal']))); ?></h5>
            <a href="cadastrar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
        </div>
        <iframe src="editar_iframe.php?tipo=<?php echo htmlspecialchars($_GET['modal']); ?><?php echo isset($_GET['id']) ? '&id=' . htmlspecialchars($_GET['id']) : ''; ?>" 
        style="width: 100%; height: calc(100% - 50px); border: none;"></iframe>
    </div>
</div>
<?php endif; ?>