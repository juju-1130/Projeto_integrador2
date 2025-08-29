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
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Orçamento"); ?>

        <?php
        $tipos_telhado = array("Cerâmico", "Fibrocimento", "Metálico", "Laje", "Solo");
        $tipos_fase = array("Monofásico", "Bifásico", "Trifásico");
        $concessionarias = array("RGE", "CEEE", "Certel");
        $marcas_inversor = array("Chint", "Growatt", "Solis", "SAJ");
        $potencias_placas = array("570W", "585W", "610W", "700W");
        $meses = array(
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        );
        
        function gerarOptions($array, $selected = "") {
            $options = "";
            foreach ($array as $valor) {
                $isSelected = ($valor == $selected) ? 'selected' : '';
                $options .= "<option value=\"$valor\" $isSelected>$valor</option>";
            }
            return $options;
        }
        
        function gerarTabelaMeses($meses) {
            $html = '';
            foreach ($meses as $mes) {
                $html .= "
                <tr>
                    <td>$mes</td>
                    <td><input type=\"number\" class=\"form-control\" name=\"consumo_$mes\"></td>
                </tr>";
            }
            return $html;
        }

        ?>
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
                            <form method="POST" action="">
                                <div class="card shadow p-4">
                                    <h2 class="text-center text-primary mb-4">Preencha seus dados para o orçamento</h2>
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sua cidade</label>
                                            <input type="text" class="form-control" name="cidade" placeholder="Digite sua cidade">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Seu telhado</label>
                                            <select class="form-select" name="telhado">
                                                <?php echo gerarOptions($tipos_telhado); ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tipo de fase</label>
                                            <select class="form-select" name="fase">
                                                <?php echo gerarOptions($tipos_fase); ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Concessionária</label>
                                            <select class="form-select" name="concessionaria">
                                                <?php echo gerarOptions($concessionarias); ?>
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
                                                <?php echo gerarTabelaMeses($meses); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Marca inversor</label>
                                            <select class="form-select" name="marca_inversor">
                                                <?php echo gerarOptions($marcas_inversor); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Potência placas</label>
                                            <select class="form-select" name="potencia_placas">
                                                <?php echo gerarOptions($potencias_placas); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="salvar_orçamento.php" class="btn btn-lg btn-primary">Calcular Orçamento</a>
                                    </div>
                                </div>
                            </form>
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