<nav class="navbar navbar-expand-lg bg-white text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img 
                src="../images/MKLOGO.png" 
                alt="MK Energia Solar" 
                class="img-fluid logo-resposivo">
        </a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded text-primary " href="contato.php">Fale Conosco</a></li>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="orcamento.php">Orçamento</a></li>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="projetos.php">Projetos</a></li>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <div class="dropdown">
                        <a class="btn btn-primary py-3 px-4 rounded dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                            <strong>Primeiro Nome</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#" onclick="logout()">Sair</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>