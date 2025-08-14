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
        <?php include __DIR__ . '/../includes/nav_autenticado.php'; ?>
        <!--Seção bem vindo-->
        <section class="page-section bg-primary text-white mb-0" id="title">
            <div class="container">
                <h5 class="page-section-heading text-primary text-uppercase text-white">Meus orçamentos</h5>
            </div>
        </section>
        <section class="page-section" id="meus-orcamentos">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow p-4 mb-4">
                            <h4 class="text-center text-primary mb-3">Orçamento 1</h4>
                            <embed src="../images/orcamento.pdf#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" class="w-100 rounded border mb-3" style="height: 85vh;">
                            <div class="text-end mb-5">
                                <a href="../images/orcamento.pdf" download="Orçamento_1.pdf" class="btn btn-outline-success">
                                    <i class="fas fa-download me-2"></i>Salvar PDF
                                </a>
                            </div>

                            <h4 class="text-center text-primary mb-3">Orçamento 2</h4>
                            <embed src="../images/orcamento.pdf#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" class="w-100 rounded border mb-3" style="height: 85vh;">
                            <div class="text-end">
                                <a href="../images/orcamento.pdf" download="Orçamento_2.pdf" class="btn btn-outline-success">
                                    <i class="fas fa-download me-2"></i>Salvar PDF
                                </a>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="contato.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i>Solicitar Visita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
