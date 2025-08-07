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
        <nav class="navbar navbar-expand-lg bg-white text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top">
                    <img 
                        src="../images/MKLOGO.png" 
                        alt="MK Energia Solar" 
                        class="img-fluid logo-resposivo">
                </a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded text-primary " href="contato.html">Fale Conosco</a></li>
                        <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded bg-primary" href="orcamento.html">Orçamento</a></li>
                        <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto"><a class="nav-link py-3 px-0 px-lg-3 rounded text-primary" href="projetos.html">Projetos</a></li>
                        <li class="nav-item mx-0 mx-lg-1 w-100 w-lg-auto">
                            <div class="dropdown">
                                <a class="btn btn-primary py-3 px-4 rounded dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i>
                                    <strong>Primeiro Nome</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#" onclick="logout()">Sair</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--Seção titulo-->
        <section class="page-section bg-primary text-white mb-0" id="title">
            <div class="container">
                <h5 class="page-section-heading text-primary text-uppercase text-white">Orçamento</h5>
            </div>
        </section>
        <header>
            <div class="text-center my-4">
                <a href="meus_orcamentos.html" class="btn btn-outline-primary">
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
                                    <a href="salvar_orçamento.html" class="btn btn-lg btn-primary">Calcular Orçamento</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <!-- Seção marcas -->
        <section id="client-holder" data-aos="fade-up" style="margin-top: 80px;">
            <div class="container">
                <h2 class="page-section-heading text-start text-uppercase text-primary mb-3">Marcas que trabalhamos</h2>
                <div class="row">
                    <div class="inner-content pt-4 mb-4">
                        <div class="logo-wrap">
                            <div class="logos">
                                <a href="#"><img src="../images/chint.png" alt="client"></a>
                                <a href="#"><img src="../images/growatt.png" alt="client"></a>
                                <a href="#"><img src="../images/solis.png" alt="client"></a>
                                <a href="#"><img src="../images/saj.png" alt="client"></a>
                                <a href="#"><img src="../images/sunova.jpg" alt="client"></a>
                                <a href="#"><img src="../images/tsun.jpg" alt="client"></a>
                                <a href="#"><img src="../images/osda.jpeg" alt="client"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer text-center bg-primary text-white py-5">
            <div class="container">
                <div class="mb-4">
                <img src="../images/MKLOGO.png" alt="MK Energia Solar" class="img-fluid footer-logo" style="max-height: 80px;">
                </div>
                <div class="d-flex justify-content-center mb-4">
                <a class="btn btn-outline-light btn-social mx-2" href="https://www.facebook.com/MKferragenseEletrica" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light btn-social mx-2" href="https://www.instagram.com/mkenergiasolareferragens" target="_blank"><i class="fab fa-instagram"></i></a>
                <a class="btn btn-outline-light btn-social mx-2" href="https://wa.me/5551998224220" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
                <div class="row text-start justify-content-center">
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Contato</h5>
                    <p class="mb-1"><i class="fas fa-phone-alt me-2"></i>(51) 99822-4220</p>
                    <p><i class="fas fa-envelope me-2"></i>mkferragenseeletrica@gmail.com</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Endereço</h5>
                    <p>Av. Tenente Pedro Von Muhlen, 609<br>Centro, Rolante - RS</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Horário</h5>
                    <p>Seg a Sex: 7:30–11:30 / 13:15–18:30<br>Sábado: 8:00–11:30</p>
                </div>
                </div>
                <hr class="bg-light opacity-25">
                <p class="small mb-0 text-white-50">&copy; 2025 MK Energia Solar - Todos os direitos reservados</p>
            </div>
        </footer>
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
