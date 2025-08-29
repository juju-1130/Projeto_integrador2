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
        <?php
        include __DIR__ . '/../includes/funcoes.php';

        $vendedores = [
            [
                'nome' => 'Jonathan Kirsch',
                'numero' => '5551999999999',
                'cargo' => 'Especialista em Energia Solar e CEO',
                'descricao' => 'Atendimento personalizado para encontrar a melhor solução em energia solar para sua necessidade.',
                'mensagem' => 'Olá Jonathan, gostaria de informações sobre energia solar'
            ],
            [
                'nome' => 'Dhonavan Dias', 
                'numero' => '5551999999998',
                'cargo' => 'Consultor e Especialista em Energia Solar',
                'descricao' => 'Especialista em projetos personalizados para maximizar sua economia com energia solar.',
                'mensagem' => 'Olá Dhonavan, gostaria de informações sobre energia solar'
            ],
            [
                'nome' => 'MK Energia Solar',
                'numero' => '5551999999997',
                'cargo' => 'Especialista em Garantir Maior Comodidade aos Clientes',
                'descricao' => 'Empresa Especialista em Energia Solar',
                'mensagem' => 'Olá MK, gostaria de informações sobre energia solar'
            ]
        ];

        function gerarLinkWhatsApp($numero, $mensagem) {
            return "https://wa.me/" . $numero . "?text=" . urlencode($mensagem);
        }

        function primeiroNome($nomeCompleto) {
            $nomes = explode(' ', $nomeCompleto);
            return $nomes[0];
        }
        ?>

        <!-- Navigation-->
        <?php include __DIR__ . '/../includes/nav_autenticado.php'; ?>
        
        <!-- Masthead-->
        <!--Seção título-->
        <?php echo gerarTituloPagina('Nossos Vendedores'); ?>
        
        <header>
        <!-- Seção Vendedores -->
        <section class="page-section py-5" id="vendedores" style="margin-top: 30px;">
            <div class="container">
                <div class="row g-4">
                    <?php foreach ($vendedores as $vendedor): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="position-relative mb-4">
                                    <img src="../images/icone.png" class="rounded-circle shadow" width="120" height="120">
                                </div>
                                <h4 class="card-title mb-2"><?php echo $vendedor['nome']; ?></h4>
                                <p class="text-muted mb-3"><?php echo $vendedor['cargo']; ?></p>
                                <p class="card-text mb-4"><?php echo $vendedor['descricao']; ?></p>
                                <a href="<?php echo gerarLinkWhatsApp($vendedor['numero'], $vendedor['mensagem']); ?>" 
                                class="btn btn-success w-100" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Falar com <?php echo primeiroNome($vendedor['nome']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Informação sobre horário comercial -->
                <div class="alert alert-info mt-5">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 fs-4"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Horário de Atendimento</h5>
                            <p class="mb-0">Nossos vendedores estão disponíveis de Segunda a Sexta, das 7:30h às 11:30h e das 13:15h às 18:30h e no Sábado, das 8:00h às 11:30 . Fora deste horário, você pode enviar uma mensagem pelo WhatsApp que retornaremos assim que possível.</p>
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