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
        <!-- Masthead-->
        <?php include __DIR__ . '/../includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina("Projetos Concluídos"); ?>

        <header>
        <header>
        <section class="page-section projects" id="projects">
            <div class="container">
                <?php
                $projetos = [
                    [
                        'imagem' => '../images/project1.png',
                        'titulo' => 'Sistema solar de 6,27Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '11 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project2.png',
                        'titulo' => 'Sistema solar de 5,49Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 610W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project3.jpg',
                        'titulo' => 'Sistema solar de 5,13Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project4.jpg',
                        'titulo' => 'Sistema solar de 5,13Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project5.jpg',
                        'titulo' => 'Sistema solar de 5,13Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project6.jpg',
                        'titulo' => 'Sistema solar de 5,13Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ],
                    [
                        'imagem' => '../images/project7.jpg',
                        'titulo' => 'Sistema solar de 5,13Kwp',
                        'cidade' => 'Cidade de Rolante',
                        'modulos' => '9 módulos de 570W',
                        'inversor' => 'Inversor Chint de 5Kw',
                        'economia' => 'Economia: R$ 350/mês',
                        'data' => 'Concluído: Jan/2023',
                        'categorias' => ['Residencial', 'Sustentável']
                    ]
                ];

                function gerarProjeto($projeto) {
                    $html = '<div class="project-card mb-5 p-4 rounded-3 bg-light">';
                    $html .= '<div class="row align-items-center g-4">';
                    $html .= '<div class="col-lg-5 col-md-6">';
                    $html .= '<img src="' . $projeto['imagem'] . '" class="img-fluid rounded shadow projeto-img" alt="Sistema solar ' . strtolower($projeto['categorias'][0]) . '">';
                    $html .= '</div>';
                    $html .= '<div class="col-lg-7 col-md-6">';
                    $html .= '<div class="ps-lg-4">';
                    $html .= '<h3 class="project-title mb-3">' . $projeto['titulo'] . '</h3>';
                    $html .= '<ul class="project-features list-unstyled">';
                    $html .= '<li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> ' . $projeto['cidade'] . '</li>';
                    $html .= '<li class="mb-2"><i class="fas fa-solar-panel text-primary me-2"></i> ' . $projeto['modulos'] . '</li>';
                    $html .= '<li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i> ' . $projeto['inversor'] . '</li>';
                    $html .= '<li class="mb-2"><i class="fas fa-battery-three-quarters text-primary me-2"></i> ' . $projeto['economia'] . '</li>';
                    $html .= '</ul>';
                    $html .= '<div class="project-meta mt-3 small text-muted">';
                    $html .= '<span class="me-3"><i class="far fa-calendar-alt me-1"></i> ' . $projeto['data'] . '</span>';
                    $html .= '</div>';
                    $html .= '<div class="mt-3">';
                    
                    foreach ($projeto['categorias'] as $categoria) {
                        $badgeClass = ($categoria == 'Residencial') ? 'bg-primary' : 'bg-success';
                        $html .= '<span class="badge ' . $badgeClass . ' me-2">' . $categoria . '</span>';
                    }
                    
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    
                    return $html;
                }

                foreach ($projetos as $projeto) {
                    echo gerarProjeto($projeto);
                }
                ?>
            </div>
        </section>
        <!-- End section projetos-->
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