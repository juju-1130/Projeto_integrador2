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
                <h5 class="page-section-heading text-primary text-uppercase text-white">Orçamento para você</h5>
            </div>
        </section>
        <!-- Masthead-->
        <header>
            <section class="page-section" id="orcamento">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow p-4">
                                <!-- Ações -->
                                <div class="d-flex gap-2 flex-wrap mb-4 justify-content-center">
                                    <a href="meus_orcamentos.php" class="btn btn-outline-primary mb-2 mb-md-0">
                                        <i class="fas fa-list me-2"></i>Meus orçamentos
                                    </a>
                                    <!-- Essa função salvará o orçamento que está sendo mostrado e salva em meus orçamentos-->
                                    <button class="btn btn-primary" onclick="mostrarMensagemSalvo()">
                                        <i class="fas fa-save me-2"></i>Salvar orçamento atual
                                    </button>
                                </div>
                                <!-- PDF -->
                                <div class="text-center mb-5">
                                    <div class="position-relative" style="height: 500px;">
                                        <embed src="../images/orcamento.pdf" type="application/pdf" width="100%" height="100%" class="rounded border">
                                        <button onclick="expandirPDF()" class="btn btn-light btn-sm position-absolute top-0 end-0 mt-2 me-2" title="Expandir">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <!-- Placas -->
                                    <div class="col-md-6 ">
                                        <label for="quantidadePlacas" class="form-label fw-bold">Quantidade de placas solares</label>
                                        <div class="d-flex align-items-center" style="max-width: 200px;">
                                            <button class="btn btn-outline-primary btn-sm me-2" type="button" onclick="diminuirPlacas()" style="width: 40px;">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center" id="quantidadePlacas" value="10" min="1" readonly style="width: 60px;">
                                            <button class="btn btn-outline-primary btn-sm ms-2" type="button" onclick="aumentarPlacas()" style="width: 40px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Inversor -->
                                    <div class="col-md-6">
                                        <label for="modeloInversor" class="form-label fw-bold">Modelo do inversor</label>
                                        <select class="form-select" id="modeloInversor">
                                            <option value="1">Inversor 3kW</option>
                                            <option value="2">Inversor 5kW</option>
                                            <option value="3">Inversor 6kW</option>
                                            <option value="4">Inversor 8kW</option>
                                            <option value="5">Inversor 10kW</option>
                                        </select>
                                    </div>
                                </div>
                                <!--Depois ao clicar aqui, será considerado todas as informações colocadas pelo usuario, somente ele poderá mudar aqui a quantidade de placas e o inversor para poder ver outro valor-->
                                <div class="text-center mt-4">
                                    <button class="btn btn-success px-4 py-2 text-nowrap w-auto">
                                        <i class="fas fa-calculator me-2"></i>Verificar novo orçamento
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>
        <script>
        function aumentarPlacas() {
            const input = document.getElementById("quantidadePlacas");
            input.value = parseInt(input.value) + 1;
        }

        function diminuirPlacas() {
            const input = document.getElementById("quantidadePlacas");
            if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            }
        }

        function expandirPDF() {
             window.open('../images/Documentação.pdf', '_blank');
        }

        function abrirEmTelaCheia() {
            const pdfUrl = '../images/Documentação.pdf';
            window.open(pdfUrl, '_blank');
        }

        function mostrarMensagemSalvo() {
        alert("Orçamento salvo com sucesso!");
        }

        </script>
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
