<?php
$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? '';

if (!empty($tipo)) {
    switch ($tipo) {
        case 'novo_vendedor':
            include __DIR__ . '/crud_vendedor/novo_vendedor.php';
            break;
        case 'editar_vendedor':
            include __DIR__ . '/crud_vendedor/editar_vendedores.php';
            break;
        case 'excluir_vendedor':
            include __DIR__ . '/crud_vendedor/excluir_vendedor.php';
            break;
        case 'novo':
            include __DIR__ . '/crud_projeto/novo_projeto.php';
            break;
        case 'editar_projeto':
            include __DIR__ . '/crud_projeto/editar_projeto.php';
            break;
        case 'excluir_projeto':
            include __DIR__ . '/crud_projeto/excluir_projeto.php';
            break;
        case 'telhado':
            include __DIR__ . '/../forms/form_telhado.php';
            break;
        case 'fase':
            include __DIR__ . '/../forms/form_fase.php';
            break;
        case 'concessionaria':
            include __DIR__ . '/../forms/form_concessionaria.php';
            break;
        case 'placa':
            include __DIR__ . '/../forms/form_placa.php';
            break;
        case 'kit':
            include __DIR__ . '/../forms/kit_solar.php';
            break;
        case 'vendedor':
            include __DIR__ . '/../forms/editar_vendedor.php';
            break;
        case 'projeto':
            include __DIR__ . '/../forms/cadastrar.php';
            break;
        case 'inversor':
            include __DIR__ . '/../forms/form_inversor.php';
            break;
        default:
            echo '<div class="alert alert-warning">Tipo não reconhecido: ' . htmlspecialchars($tipo) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">Nenhum tipo especificado</div>';
}
?>