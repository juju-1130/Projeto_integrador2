<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: index.php" . str_replace('?sair=true', '', $_SERVER['REQUEST_URI']));
    exit;
}

$pagina_atual = basename($_SERVER['PHP_SELF']);
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? (int)$_SESSION['tipo_usuario'] : null;
$logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
$nome_usuario = $_SESSION['nome_usuario'] ?? 'Usuário';

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
            <img src="<?= ($tipo_usuario !== null ? '../' : '') ?>images/MKLOGO.png" 
                 alt="MK Energia Solar" 
                 class="img-fluid logo-resposivo">
        </a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" 
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" 
                aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

                <?php if (!$logado): ?>
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
                        <a class="nav-link py-3 px-0 px-lg-3 rounded bg-primary text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login/Cadastre-se</a>
                    </li>

                <?php elseif ($logado && $tipo_usuario === 0): ?>
                    <li class="nav-item mx-0 mx-lg-1 w-auto">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="contato.php">Fale Conosco</a>
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
                                <strong><?= htmlspecialchars($nome_usuario) ?></strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="<?= $pagina_atual ?>?confirmar_logout=true">Sair</a></li>
                            </ul>
                        </div>
                    </li>

                <?php elseif ($logado && $tipo_usuario === 1): ?>
                     
                    <?php if (mostrar_botao('editar_dados')): ?>
                    <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                        <a class="btn btn-primary py-3 px-4 rounded me-2" href="admin_php/editar.php">Editar Dados</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (mostrar_botao('home')): ?>
                    <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto mb-2 mb-lg-0">
                        <a class="btn btn-primary py-3 px-4 rounded me-2" href="index.php">Home</a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                        <div class="dropdown w-100">
                            <a class="btn btn-primary py-3 px-4 rounded dropdown-toggle text-start" href="#" role="button" 
                               id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <strong><?= htmlspecialchars($nome_usuario) ?></strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="<?= $pagina_atual ?>?confirmar_logout=true">Sair</a></li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php if (!$logado): ?>
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
<?php endif; ?>