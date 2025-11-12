<?php
session_start();
require_once __DIR__ . '/conexao.php';

// Agora você pode usar $conn ou a variável que o conexao.php define

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../autenticacao/login.php');
    exit();
}

// Dados do usuário logado
$nome = $_SESSION['nome_usuario'] ?? '';
$email = $_SESSION['email_usuario'] ?? '';
$telefone = $_SESSION['telefone_usuario'] ?? '';

// Consulta os dados do banco para os selects
$telhados = $conn->query("SELECT telhado_id, tipo_telhado FROM Telhado ORDER BY tipo_telhado ASC");
$fases = $conn->query("SELECT fase_id, tipo_fase FROM Fase ORDER BY tipo_fase ASC");
$concessionarias = $conn->query("SELECT concessionaria_id, nome_concessionaria FROM Concessionaria ORDER BY nome_concessionaria ASC");

// Marcas e potências (se você tem tabelas, podemos substituir por query; por enquanto mantive estes como fallback)
$marcas_inversor = $conn->query("SELECT inversor_id, marca_inversor FROM Inversor ORDER BY marca_inversor ASC");
$potencias_placas = $conn->query("SELECT placa_id, potencia_placa FROM Placa ORDER BY potencia_placa ASC");

// Meses de consumo
$meses = [
    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];
?>
<!DOCTYPE html>
<html lang="en">
    <?php include __DIR__ . '/head.php'; ?>
<body id="page-top">
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <?php include __DIR__ . '/includes/funcoes.php'; ?>

    <?php echo gerarTituloPagina("Orçamento"); ?>

    <div class="container">
        <div class="text-center my-4">
            <a href="orcamento/meus_orcamentos.php" class="btn btn-outline-primary">
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

                            <!-- Início do formulário -->
                            <form action="orcamento/salvar_orcamento.php" method="POST" class="needs-validation" novalidate>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sua cidade</label>
                                        <input type="text" name="cidade_cliente" class="form-control" placeholder="Digite sua cidade" value="" required>
                                        <div class="invalid-feedback">Informe sua cidade.</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seu telhado</label>
                                        <select class="form-select" name="telhado_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($telhados): while ($row = $telhados->fetch_assoc()): ?>
                                                <option value="<?= $row['telhado_id'] ?>"><?= htmlspecialchars($row['tipo_telhado']) ?></option>
                                            <?php endwhile; endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Selecione o tipo de telhado.</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de fase</label>
                                        <select class="form-select" name="fase_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($fases): while ($row = $fases->fetch_assoc()): ?>
                                                <option value="<?= $row['fase_id'] ?>"><?= htmlspecialchars($row['tipo_fase']) ?></option>
                                            <?php endwhile; endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Selecione a fase elétrica.</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Concessionária</label>
                                        <select class="form-select" name="concessionaria_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($concessionarias): while ($row = $concessionarias->fetch_assoc()): ?>
                                                <option value="<?= $row['concessionaria_id'] ?>"><?= htmlspecialchars($row['nome_concessionaria']) ?></option>
                                            <?php endwhile; endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Selecione a concessionária.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tarifa de Energia (R$/kWh)</label>
                                        <input type="number" step="0.01" min="0" name="tarifa" class="form-control" value="0.85" required>
                                        <div class="invalid-feedback">Informe a tarifa de energia.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de Instalação</label>
                                        <select class="form-select" name="tipo_instalacao" required>
                                            <option value="">Selecione</option>
                                            <option value="Residencial">Residencial</option>
                                            <option value="Comercial">Comercial</option>
                                            <option value="Rural">Rural</option>
                                            <option value="Industrial">Industrial</option>
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
                                            <?php foreach ($meses as $mes): ?>
                                            <tr>
                                                <td><?= $mes ?></td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="consumo_mes[]" class="form-control" required>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Marca inversor</label>
                                        <select class="form-select" name="inversor_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($marcas_inversor && $marcas_inversor->num_rows > 0): ?>
                                                <?php while ($m = $marcas_inversor->fetch_assoc()): ?>
                                                    <option value="<?= $m['inversor_id'] ?>"><?= htmlspecialchars($m['marca_inversor']) ?></option>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <option value="1">Chint</option>
                                                <option value="2">Growatt</option>
                                                <option value="3">Solis</option>
                                                <option value="4">SAJ</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Selecione a marca do inversor.</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Potência placas</label>
                                        <select class="form-select" name="placa_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($potencias_placas && $potencias_placas->num_rows > 0): ?>
                                                <?php while ($p = $potencias_placas->fetch_assoc()): ?>
                                                    <option value="<?= $p['placa_id'] ?>"><?= htmlspecialchars($p['potencia_placa']) ?> W</option>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <option value="1">570 W</option>
                                                <option value="2">585 W</option>
                                                <option value="3">610 W</option>
                                                <option value="4">700 W</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Selecione a potência das placas.</div>
                                    </div>
                                </div>

                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-lg btn-primary">Calcular Orçamento</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Seção marcas e footer mantém igual ao seu template original -->
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

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>

    <script>
    // Bootstrap form validation (mantém comportamento padrão Bootstrap)
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })();
    </script>
</body>
</html>
