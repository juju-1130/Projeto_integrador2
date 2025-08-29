<?php
function gerarTituloPagina($titulo, $classeBg = 'bg-primary', $id = 'title') {

    $tituloSeguro = htmlspecialchars($titulo);
    $tituloSeguro = str_replace('&lt;br&gt;', '<br>', $tituloSeguro);
    $tituloSeguro = str_replace('&lt;br/&gt;', '<br>', $tituloSeguro);
    
    return '
    <section class="page-section ' . $classeBg . ' text-white mb-0" id="' . $id . '">
        <div class="container">
            <h5 class="page-section-heading text-uppercase text-white">' . $tituloSeguro . '</h5>
        </div>
    </section>';
}
?>