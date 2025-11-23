<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include __DIR__ . '/head.php'; ?>
    <body id="page-top">
        <!-- Navigation-->
        <?php include __DIR__ . '/includes/navbar.php'; ?>
        <?php include __DIR__ . '/autenticacao/login.php'; ?>
        <?php include __DIR__ . '/autenticacao/cadastrar.php'; ?>
        <?php include __DIR__ . '/autenticacao/esquecisenha.php'; ?>
        <!--Seção bem vindo-->
        <?php include __DIR__ . '/includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Seja Bem Vindo à <br> MK energia solar"); ?>

        <!-- Masthead-->
        <header>
        <!-- Começo carrossel -->
            <div class="container-fluid px-0 mb-5">
                <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="w-100" src="images/sistema1.jpg" alt="Image">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 text-start">
                                            <h1 class="display-2 fw-bold text-shadow">Soluções em <br> Energia Solar</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="w-100" src="images/sistema2.jpg" alt="Image">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 text-start">
                                            <h1 class="display-2 fw-bold text-shadow">Soluções em <br> Energia Solar</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="w-100" src="images/sistema3.jpg" alt="Image">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 text-start">
                                            <h1 class="display-2 fw-bold text-shadow">Soluções em <br> Energia Solar</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        <!-- Final carrossel -->
        </header>
        <!-- Local Section-->
        <section class="page-section local py-5" id="local">
            <div class="container">
                <div class="text-start mb-5">
                    <h2 class="page-section-heading text-uppercase text-primary d-inline-block">
                        Onde Estamos
                    </h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="position-relative h-100">
                            <img src="images/frenteloja.jpg" class="img-fluid rounded-3 shadow-lg w-100 h-100" style="object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 bg-primary text-white p-3 rounded-end">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-store me-2 fs-4"></i>
                                    <div>
                                        <h5 class="mb-0">MK Energia Solar</h5>
                                        <small>Loja Física</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body p-0">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3467.3801796015564!2d-50.57024942446128!3d-29.650740375124116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9518e458541955c3%3A0xb65898b1e540ff08!2sMK%20Energia%20Solar!5e0!3m2!1spt-BR!2sbr!4v1751330538925!5m2!1spt-BR!2sbr" 
                                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div class="p-4">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-map-marker-alt fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-0">Endereço</h5>
                                            <p class="mb-0">Av. Tenente Pedro Von Muhlen, 609 - Centro, Rolante - RS</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-clock fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-0">Horário de Funcionamento</h5>
                                            <p class="mb-0">Seg-Sex: 7:30hs às 11:30hs e das 13:15hs às 18:30hs<br>Sábado: 8h às 11:30h</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-phone-alt fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-0">Telefone</h5>
                                            <p class="mb-0">(51) 99822 4220</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Google Maps -->
        <!-- Section projetos em destaque -->
        <section class="page-section projects" id="projects">
            <div class="container">
                <h2 class="page-section-heading text-uppercase text-primary d-inline-block mb-5">
                    Projetos em destaque
                </h2>
                
                <div id="projetos-destacados-container">
                </div>

                <div id="sem-projetos-destacados" class="text-center py-5" style="display: none;">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum projeto em destaque</h4>
                    <p class="text-muted">Os projetos destacados aparecerão aqui.</p>
                </div>
            </div>
        </section>
        <!-- End section projetos-->
         <!-- Seção sobre-->
        <section class="page-section text-primary mb-0 pt-2" id="about">
            <div class="container">
                <h2 class="page-section-heading text-start text-uppercase text-primary mb-4">Sobre nós</h2>
                <div class="row">
                    <div class="col-lg-7 ms-0 text-start"><p class="about-text">Com mais de 13 anos de experiência, somos uma empresa consolidada no mercado, com sede própria na cidade de Rolante. Atendemos com excelência nos segmentos de energia solar e elétrica, além de oferecermos uma linha completa de produtos automotivos e ferragens.

        <br>Somos especialistas em energia solar, com mais de 1.000 projetos homologados e atuação em mais de 30 cidades da região. Nossos serviços contam com mão de obra própria e especializada, garantindo segurança, qualidade e eficiência do início ao fim do projeto.

        <br>Na parte automotiva e de ferragens, disponibilizamos uma ampla variedade de produtos das melhores marcas, sempre com o atendimento atencioso e suporte técnico que fazem a diferença.

        <br>Como diferencial, oferecemos ainda um eletroposto gratuito e disponível 24 horas, reforçando nosso compromisso com a mobilidade sustentável e com o futuro.

        <br>Conte com a nossa experiência, estrutura e dedicação para soluções confiáveis e sob medida para cada necessidade.</p></div>
                </div>
            </div>
        </section>
        <!-- Seção marcas -->
        <?php include __DIR__ . '/includes/marcas.php'; ?>
        <!-- Footer-->
        <?php include __DIR__ . '/includes/footer.php'; ?>

        <script>
        <?php if (isset($_GET['show_login']) && $_GET['show_login'] == '1'): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                history.replaceState({}, document.title, '<?= BASE_URL ?>/index.php');
            });
        <?php endif; ?>
        // Função para carregar e exibir projetos destacados
        function carregarProjetosDestacados() {
            const container = document.getElementById('projetos-destacados-container');
            const semProjetosMsg = document.getElementById('sem-projetos-destacados');
            const projetosDestacados = JSON.parse(localStorage.getItem('projetosDestacados')) || [];

            // Limpar container
            container.innerHTML = '';

            if (projetosDestacados.length === 0) {
                semProjetosMsg.style.display = 'block';
                container.style.display = 'none';
                return;
            }

            semProjetosMsg.style.display = 'none';
            container.style.display = 'block';

            // Gerar HTML para cada projeto destacado
            projetosDestacados.forEach((projeto, index) => {
                const isEven = index % 2 === 0;
                
                const projetoHTML = `
                    <div class="project-card mb-5 p-4 rounded-3 bg-light">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-5 col-md-6 ${!isEven ? 'order-lg-2 order-2' : ''}">
                                <img src="${projeto.imagem}" 
                                    class="img-fluid rounded shadow projeto-img" 
                                    alt="${projeto.titulo}">
                            </div>
                            <div class="col-lg-7 col-md-6 ${!isEven ? 'order-lg-1 order-1' : ''}">
                                <div class="${isEven ? 'ps-lg-4' : 'pe-lg-4'}">
                                    <h3 class="project-title mb-3">${projeto.titulo}</h3>
                                    <div class="project-features">
                                        ${projeto.detalhes}
                                    </div>
                                    <div class="project-meta mt-3 small text-muted">
                                        ${projeto.meta}
                                    </div>
                                    <div class="mt-3">
                                        ${projeto.tags.join('')}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += projetoHTML;
            });
        }

        // Carregar projetos destacados quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            carregarProjetosDestacados();
        });

        // Atualizar projetos destacados quando o localStorage mudar (em outras abas)
        window.addEventListener('storage', function(e) {
            if (e.key === 'projetosDestacados') {
                carregarProjetosDestacados();
            }
        });

        // Gerenciar mensagens de login/cadastro
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar se deve mostrar modal de login
            <?php if (isset($_GET['show_login']) && $_GET['show_login'] == '1'): ?>
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                history.replaceState({}, document.title, '<?= BASE_URL ?>/index.php');
            <?php endif; ?>
            
            // Verificar se deve mostrar modal de cadastro
            <?php if (isset($_GET['show_cadastro']) && $_GET['show_cadastro'] == '1'): ?>
                var cadastroModal = new bootstrap.Modal(document.getElementById('cadastrarModal'));
                cadastroModal.show();
                history.replaceState({}, document.title, '<?= BASE_URL ?>/index.php');
            <?php endif; ?>

            // Verificar mensagens do localStorage
            const loginError = localStorage.getItem('loginError');
            const loginSuccess = localStorage.getItem('loginSuccess');
            const cadastroError = localStorage.getItem('cadastroError');
            const cadastroSuccess = localStorage.getItem('cadastroSuccess');

            if (loginError) {
                mostrarMensagemLogin(loginError, 'error');
                localStorage.removeItem('loginError');
            }

            if (loginSuccess) {
                window.location.reload();
                localStorage.removeItem('loginSuccess');
            }

            if (cadastroError) {
                mostrarMensagemCadastro(cadastroError, 'error');
                localStorage.removeItem('cadastroError');
            }

            if (cadastroSuccess) {
                mostrarMensagemCadastro(cadastroSuccess, 'success');
                localStorage.removeItem('cadastroSuccess');
                
                // Fechar modal de cadastro após 2 segundos e abrir login
                setTimeout(() => {
                    var cadastroModal = bootstrap.Modal.getInstance(document.getElementById('cadastrarModal'));
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    cadastroModal.hide();
                    loginModal.show();
                }, 2000);
            }
        });

        function mostrarMensagemLogin(mensagem, tipo) {
            const container = document.getElementById('login-message-container');
            if (!container) return;
            
            container.innerHTML = `
                <div class="alert alert-${tipo === 'error' ? 'danger' : 'success'} alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${mensagem}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        function mostrarMensagemCadastro(mensagem, tipo) {
            const container = document.getElementById('cadastro-message-container');
            if (!container) return;
            
            container.innerHTML = `
                <div class="alert alert-${tipo === 'error' ? 'danger' : 'success'} alert-dismissible fade show" role="alert">
                    <i class="fas ${tipo === 'error' ? 'fa-exclamation-triangle' : 'fa-check-circle'} me-2"></i>
                    ${mensagem}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
        </script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    </body>
</html>
