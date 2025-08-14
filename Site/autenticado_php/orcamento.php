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
        <!--Seção titulo-->
        <section class="page-section bg-primary text-white mb-0" id="title">
            <div class="container">
                <h5 class="page-section-heading text-primary text-uppercase text-white">Orçamento</h5>
            </div>
        </section>
        <header>
            <div class="text-center my-4">
                <a href="meus_orcamentos.php" class="btn btn-outline-primary">
                    <i class="fas fa-list me-2"></i>Meus orçamentos
                </a>
            </div>
        <!--Seção dados orçamento-->
            <section class="page-section" id="orcamento">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow p-4">
                                <h2 class="text-center text-primary mb-4">Preencha seus dados para o orçamento</h2>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sua cidade</label>
                                        <input type="text" class="form-control" placeholder="Digite sua cidade">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seu telhado</label>
                                        <select class="form-select">
                                            <option>Cerâmico</option>
                                            <option>Fibrocimento</option>
                                            <option>Metálico</option>
                                            <option>Laje</option>
                                            <option>Solo</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de fase</label>
                                        <select class="form-select">
                                            <option>Monofásico</option>
                                            <option>Bifásico</option>
                                            <option>Trifásico</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Concessionária</label>
                                        <select class="form-select">
                                            <option>RGE</option>
                                            <option>CEEE</option>
                                            <option>Certel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Mês</th>
                                                <th>Consumo (kWh)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Janeiro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Fevereiro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Março</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Abril</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Maio</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Junho</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Julho</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Agosto</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Setembro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Outubro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Novembro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td>Dezembro</td>
                                                <td><input type="number" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Marca inversor</label>
                                        <select class="form-select">
                                            <option>Chint</option>
                                            <option>Growatt</option>
                                            <option>Solis</option>
                                            <option>SAJ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Potência placas</label>
                                        <select class="form-select">
                                            <option>570W</option>
                                            <option>585W</option>
                                            <option>610W</option>
                                            <option>700W</option>
                                        </select>
                                    </div>
                                <!--Depois com banco de dados, ao clicar em calcular orçamento será feito uma logica e será carregado um orçamento especifico para o cliente-->
                                <div class="text-center">
                                    <a href="salvar_orçamento.php" class="btn btn-lg btn-primary">Calcular Orçamento</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <!-- Seção marcas -->
        <?php include __DIR__ . '/../includes/marcas.php'; ?>
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
