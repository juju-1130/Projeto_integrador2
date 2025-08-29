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
        <?php 
        $pagina_parametros = [
            'kit_solar.php' => ['editar_dados']
        ];

        include __DIR__ . '/../includes/nav_admin.php';
        ?>
        <!--Seção titulo-->
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Kit solar"); ?>

        <div class="container mt-5">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Custo mão de obra por placa</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalMaoObra" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Custo cabos</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalCabos" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Custo trilho por placa</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalTrilho" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Custo conectores</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalConectores" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Custos fixos</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalCustosFixos" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Custos extras</td>
                        <td class="text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalCustosExtras" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>

        <!-- Mão de obra -->
        <div class="modal fade" id="modalMaoObra" tabindex="-1" aria-hidden="true" aria-labelledby="titleMaoObra">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleMaoObra">Custo mão de obra por placa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=mao_obra" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cabos -->
        <div class="modal fade" id="modalCabos" tabindex="-1" aria-hidden="true" aria-labelledby="titleCabos">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleCabos">Custo cabos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=cabos" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trilho -->
        <div class="modal fade" id="modalTrilho" tabindex="-1" aria-hidden="true" aria-labelledby="titleTrilho">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleTrilho">Custo trilho por placa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=trilho" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conectores -->
        <div class="modal fade" id="modalConectores" tabindex="-1" aria-hidden="true" aria-labelledby="titleConectores">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleConectores">Custo conectores</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=conectores" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custos fixos -->
        <div class="modal fade" id="modalCustosFixos" tabindex="-1" aria-hidden="true" aria-labelledby="titleCustosFixos">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleCustosFixos">Custos fixos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=custos_fixos" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custos extras -->
        <div class="modal fade" id="modalCustosExtras" tabindex="-1" aria-hidden="true" aria-labelledby="titleCustosExtras">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="titleCustosExtras">Custos extras</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe src="../forms/form_custo.php?tipo=custos_extras" style="width: 100%; height: 350px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>