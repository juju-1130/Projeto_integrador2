<?php
$tipo = $_GET['tipo'] ?? '';
        if (!empty($tipo)) {
            switch ($tipo) {
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
                    echo '<div class="alert alert-warning">Tipo não reconhecido</div>';
            }
        }
?>

    
 