<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
$parametros = $_GET;

$botoes_por_pagina = [
    'cadastrar.php' => ['editar_dados'],
    'editar.php' => ['home'],
    'editar_vendedor.php' => ['editar_dados'],
    'index.php' => ['editar_dados'],
    'kit_solar.php' => ['editar_dados']
];

$botoes_ativos = $botoes_por_pagina[$pagina_atual] ?? ['editar_dados']; 

function mostrar_botao($tipo_botao) {
    global $botoes_ativos;
    return in_array($tipo_botao, $botoes_ativos);
}

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
            <img src="../images/MKLOGO.png" alt="MK Energia Solar" class="img-fluid logo-resposivo">
        </a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" 
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" 
                aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <?php if (mostrar_botao('novo')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto mb-2 mb-lg-0">
                    <a class="btn btn-primary py-3 px-4 rounded me-2" href="#" data-bs-toggle="modal" data-bs-target="#newProjectModal">Novo</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('novo_vendedor')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto mb-2 mb-lg-0">
                    <a class="btn btn-primary py-3 px-4 rounded me-2" href="#" data-bs-toggle="modal" data-bs-target="#novoVendedorModal">Novo</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('editar_projeto')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <a id="btnEditarProjeto" class="btn btn-primary py-3 px-4 rounded me-2" href="#">Editar Projeto</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('editar_vendedor')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <a id="btnEditarVendedor" class="btn btn-primary py-3 px-4 rounded me-2" href="#">Editar vendedor</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('excluir_projeto')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <a id="btnExcluirProjeto" class="btn btn-primary py-3 px-4 rounded" href="#">Excluir Projeto</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('excluir_vendedor')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <a id="btnExcluirVendedor" class="btn btn-primary py-3 px-4 rounded" href="#">Excluir vendedor</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('editar_dados')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                    <a class="btn btn-primary py-3 px-4 rounded" href="editar.php">Editar Dados</a>
                </li>
                <?php endif; ?>
                
                <?php if (mostrar_botao('home')): ?>
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto mb-2 mb-lg-0">
                    <a class="btn btn-primary py-3 px-4 rounded w-100 text-start" href="index.php">
                        Home
                    </a>
                </li>
                <?php endif; ?>
                
                <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
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