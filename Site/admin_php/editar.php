<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <?php include __DIR__ . '/../head.php'; ?>
    <body id="page-top">
        <!-- Navigation-->
        <?php 
        $pagina_parametros = [
            'editar.php' => ['home']
        ];

        include __DIR__ . '/../includes/navbar.php';
        ?>
        <!--Seção titulo-->
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Atributos do orçamento"); ?>

        <!--Tabela iframes-->
        <?php include __DIR__ . '/../includes/atributos.php'; ?>

        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>

        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
