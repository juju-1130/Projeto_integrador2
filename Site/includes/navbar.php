        <nav class="navbar navbar-expand-lg bg-white text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img 
                        src="images/MKLOGO.png" 
                        alt="MK Energia Solar" 
                        class="img-fluid logo-resposivo">
                </a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-lg-1 w-auto">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="contato.php">Fale Conosco</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1 w-auto">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="#" data-bs-toggle="modal" data-bs-target="#cadastroOrcamentoModal">Orçamento</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1 w-auto">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="projetos.php">Projetos</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1 w-auto">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded bg-primary text-white" 
                            href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#loginModal">
                            Login/Cadastre-se
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Modal Cadastro para Orçamento -->
        <div class="modal fade" id="cadastroOrcamentoModal" tabindex="-1" aria-labelledby="cadastroOrcamentoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cadastroOrcamentoModalLabel">Orçamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>Para realizar um orçamento, é necessário ter um cadastro no sistema.</p>
                        <p>Se você já tem conta, faça login. Caso contrário, cadastre-se gratuitamente.</p>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary me-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                            <button class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="document.getElementById('cadastro-tab').click()">
                                Cadastre-se
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>