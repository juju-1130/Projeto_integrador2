<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de orçamento para energia solar - MK Energia Solar" />
        <meta name="author" content="" />
        <title>Orçamento - MK Energia Solar</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
        <style>
            .pdf-container {
                position: relative;
                height: 500px;
            }
            .pdf-expand-btn {
                position: absolute;
                top: 10px;
                right: 10px;
            }
            .input-control {
                max-width: 200px;
            }
        </style>
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include __DIR__ . '/../includes/nav_autenticado.php'; ?>
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Novo Orçamento"); ?>
        
        <?php
        $quantidade_placas = 1;
        $modelo_inversor = 1;
        $mensagem = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['quantidade_placas'])) {
                $quantidade_placas = intval($_POST['quantidade_placas']);
            }
            
            if (isset($_POST['modelo_inversor'])) {
                $modelo_inversor = intval($_POST['modelo_inversor']);
            }
            
            if (isset($_POST['salvar_orcamento'])) {
                $mensagem = "Orçamento salvo com sucesso!";
            }
            
            if (isset($_POST['calcular_orcamento'])) {
                $mensagem = "Novo orçamento calculado com $quantidade_placas placas e inversor $modelo_inversor";
            }
            
            if (isset($_POST['aumentar_placas'])) {
                $quantidade_placas = intval($_POST['quantidade_placas']) + 1;
            }
            
            if (isset($_POST['diminuir_placas'])) {
                $quantidade_placas_atual = intval($_POST['quantidade_placas']);
                if ($quantidade_placas_atual > 1) {
                    $quantidade_placas = $quantidade_placas_atual - 1;
                }
            }
        }
        ?>
        
        <header>
            <section class="page-section py-4" id="orcamento">
                <div class="container">
                    <?php if (!empty($mensagem)): ?>
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <?php echo $mensagem; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow p-4">
                                <div class="d-flex gap-2 flex-wrap mb-4 justify-content-center">
                                    <a href="meus_orcamentos.php" class="btn btn-outline-primary mb-2 mb-md-0">
                                        <i class="fas fa-list me-2"></i>Meus orçamentos
                                    </a>
                                    <form method="POST">
                                        <input type="hidden" name="quantidade_placas" value="<?php echo $quantidade_placas; ?>">
                                        <input type="hidden" name="modelo_inversor" value="<?php echo $modelo_inversor; ?>">
                                        <button type="submit" name="salvar_orcamento" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Salvar orçamento atual
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="text-center mb-5">
                                    <div class="pdf-container">
                                        <embed src="../images/orcamento.pdf" type="application/pdf" width="100%" height="100%" class="rounded border">
                                        <a href="../images/orcamento.pdf" target="_blank" class="btn btn-light btn-sm pdf-expand-btn" title="Expandir">
                                            <i class="fas fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <form method="POST">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="quantidadePlacas" class="form-label fw-bold">Quantidade de placas solares</label>
                                            <div class="d-flex align-items-center input-control">
                                                <button type="submit" name="diminuir_placas" class="btn btn-outline-primary btn-sm me-2" style="width: 40px;">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" id="quantidadePlacas" 
                                                    name="quantidade_placas" value="<?php echo $quantidade_placas; ?>" min="1" readonly style="width: 60px;">
                                                <button type="submit" name="aumentar_placas" class="btn btn-outline-primary btn-sm ms-2" style="width: 40px;">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modeloInversor" class="form-label fw-bold">Modelo do inversor</label>
                                            <select class="form-select" id="modeloInversor" name="modelo_inversor">
                                                <option value="1" <?php echo $modelo_inversor == 1 ? 'selected' : ''; ?>>Inversor 3kW</option>
                                                <option value="2" <?php echo $modelo_inversor == 2 ? 'selected' : ''; ?>>Inversor 5kW</option>
                                                <option value="3" <?php echo $modelo_inversor == 3 ? 'selected' : ''; ?>>Inversor 6kW</option>
                                                <option value="4" <?php echo $modelo_inversor == 4 ? 'selected' : ''; ?>>Inversor 8kW</option>
                                                <option value="5" <?php echo $modelo_inversor == 5 ? 'selected' : ''; ?>>Inversor 10kW</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <button type="submit" name="calcular_orcamento" class="btn btn-success px-4 py-2 text-nowrap w-auto">
                                            <i class="fas fa-calculator me-2"></i>Calcular novo orçamento
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        
        <!-- Footer-->
        <?php include __DIR__ . '/../includes/footer.php'; ?>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
    </body>
</html>