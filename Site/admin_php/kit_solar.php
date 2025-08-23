<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MK Energia Solar</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include __DIR__ . '/../includes/nav_admin.php'; ?>

        <!--Seção titulo-->
        <section class="page-section bg-primary text-white mb-0" id="title">
            <div class="container">
                <h3 class="page-section-heading text-primary text-uppercase text-white">Kit solar</h3>
            </div>
        </section>
        <div class="container mt-5">
            <table class="table table-bordered">
            <tbody>
                <tr><td>Custo mão de obra por placa</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
                <tr><td>Custo cabos</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
                <tr><td>Custo trilho por placa</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
                <tr><td>Custo conectores</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
                <tr><td>Custos fixos</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
                <tr><td>Custos extras</td><td><a href="../forms/form_custo.php" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIframe" target="iframeForm">Editar</a></td></tr>
            </tbody>
            </table>
        </div>

        <!-- Modal que contém o iframe -->
        <div class="modal fade" id="modalIframe" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Custo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-0">
                <iframe name="iframeForm" style="width:100%; height:500px; border:none;"></iframe>
            </div>
            </div>
        </div>
        </div>

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
