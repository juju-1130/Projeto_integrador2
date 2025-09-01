<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
$parametros = $_GET;

if (isset($_GET['sair']) && $_GET['sair'] == 'true') {
    header('Location: ../index.php');
    exit;
}
?>

<?php if (isset($_GET['confirmar_logout'])): ?>
<div class="modal fade show" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirmação de Logout</h5>
                <button type="button" class="btn-close" onclick="window.location.href='<?= $pagina_atual ?>'" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja sair do sistema?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= $pagina_atual ?>'">Cancelar</button>
                <a href="<?= $pagina_atual ?>?sair=true" class="btn btn-primary">Sair</a>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?>

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
                <li class="nav-item mx-0 mx-lg-1 w-auto">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary " href="contato.php">Fale Conosco</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1 w-auto">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="orcamento.php">Orçamento</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1 w-auto">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="projetos.php">Projetos</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1 w-auto">
                    <div class="dropdown w-100">
                        <a class="btn btn-primary py-3 px-4 rounded dropdown-toggle text-start" href="#" role="button" 
                           id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                            <strong>Primeiro Nome</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= $pagina_atual ?>?confirmar_logout=true">Sair</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>