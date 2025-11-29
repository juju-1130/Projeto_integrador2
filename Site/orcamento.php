<?php
session_start();
require_once __DIR__ . '/conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../autenticacao/login.php');
    exit();
}

// Dados do usuário logado
$nome = $_SESSION['nome_usuario'] ?? '';
$email = $_SESSION['email_usuario'] ?? '';
$telefone = $_SESSION['telefone_usuario'] ?? '';

// Buscar último orçamento do usuário para pré-preencher
$usuario_id = $_SESSION['usuario_id'];
$ultimo_orcamento = null;
$consumos_anteriores = array_fill(0, 12, '');

$sql_ultimo = "SELECT * FROM Orcamento WHERE usuario_id = ? ORDER BY data_criacao DESC LIMIT 1";
$stmt_ultimo = $conn->prepare($sql_ultimo);
if ($stmt_ultimo) {
    $stmt_ultimo->bind_param("i", $usuario_id);
    $stmt_ultimo->execute();
    $result_ultimo = $stmt_ultimo->get_result();
    $ultimo_orcamento = $result_ultimo->fetch_assoc();
    
    if ($ultimo_orcamento) {
        $consumos_decodificados = json_decode($ultimo_orcamento['consumo_mensal_json'], true);
        if (is_array($consumos_decodificados) && count($consumos_decodificados) === 12) {
            $consumos_anteriores = $consumos_decodificados;
        }
    }
}

// Consulta os dados do banco para os selects
$telhados = $conn->query("SELECT telhado_id, tipo_telhado, foto_telhado FROM Telhado ORDER BY tipo_telhado ASC");
$fases = $conn->query("SELECT fase_id, tipo_fase FROM Fase ORDER BY tipo_fase ASC");
$concessionarias = $conn->query("SELECT concessionaria_id, nome_concessionaria FROM Concessionaria ORDER BY nome_concessionaria ASC");
$placas_query = $conn->query("SELECT placa_id, potencia_placa, marca_placa, valor_placa FROM Placa WHERE ativo = 1 ORDER BY potencia_placa ASC");$inversores_query = $conn->query("SELECT DISTINCT marca_inversor FROM Inversor WHERE marca_inversor IN ('Chint', 'Growatt', 'Solis', 'SAJ') AND ativo = 1 ORDER BY marca_inversor ASC");
// Meses de consumo
$meses = [
    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php include __DIR__ . '/head.php'; ?>
<body id="page-top">
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <?php include __DIR__ . '/includes/funcoes.php'; ?>

    <?php 
    echo gerarTituloPagina("Orçamento"); 
    carregarAPICidades(); 
    carregarFuncoesOrcamento();
    ?>

    <div class="container">
        <div class="d-flex justify-content-center gap-3 my-4">
            <a href="orcamento/meus_orcamentos.php" class="btn btn-outline-primary btn-lg w-50">
                <i class="fas fa-list me-2"></i>Meus orçamentos
            </a>
            <?php if ($ultimo_orcamento): ?>
            <button type="button" class="btn btn-outline-success btn-lg w-50" onclick="habilitarModoRapido()">
                <i class="fas fa-bolt me-2"></i>Usar Meu Último Orçamento
            </button>
            <?php endif; ?>
        </div>

        <!--Seção dados orçamento-->
        <section class="page-section" id="orcamento">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow p-4">
                            
                            <?php if ($ultimo_orcamento): ?>
                            <!-- Banner do Modo Rápido -->
                            <div id="modo-rapido-banner" class="alert alert-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-bolt me-2"></i>
                                        <strong>Modo Rápido Ativo:</strong> 
                                        Baseado no seu último projeto de 
                                        <strong><?= number_format($ultimo_orcamento['potencia_sistema_kwp'], 2, ',', '.') ?> kWp</strong>
                                        - Ajuste os campos necessários
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="desabilitarModoRapido()">
                                        <i class="fas fa-times me-1"></i>Sair do Modo Rápido
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Seção de Ajuste de Geração (SEMPRE no HTML, mas oculta inicialmente) -->
                            <div id="ajuste-geracao" class="card mb-4 border-success" style="display: none;">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sliders-h me-2"></i>Ajuste de Geração Desejada
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Geração Mensal Desejada (kWh)</label>
                                            <input type="number" 
                                                   id="geracao_desejada"
                                                   name="geracao_desejada" 
                                                   class="form-control" 
                                                   value="<?= $ultimo_orcamento ? round($ultimo_orcamento['producao_estimada'] ?? $ultimo_orcamento['consumo_mensal_medio']) : '500' ?>"
                                                   min="100" 
                                                   step="10">
                                            <div class="form-text">
                                                <?php if ($ultimo_orcamento): ?>
                                                Geração atual: ~<?= round($ultimo_orcamento['producao_estimada'] ?? $ultimo_orcamento['consumo_mensal_medio']) ?> kWh/mês
                                                <?php else: ?>
                                                Informe a geração mensal desejada
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Margem de Segurança</label>
                                            <select class="form-select" id="margem_seguranca" name="margem_seguranca">
                                                <option value="0.05">Pequena (+5%)</option>
                                                <option value="0.1" selected>Média (+10%)</option>
                                                <option value="0.15">Grande (+15%)</option>
                                                <option value="0.2">Máxima (+20%)</option>
                                            </select>
                                            <div class="form-text">Adiciona uma margem à geração desejada</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h2 class="text-center text-primary mb-4">Preencha seus dados para o orçamento</h2>

                            <!-- Início do formulário -->
                            <form action="orcamento/salvar_orcamento.php" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" id="modo_rapido" name="modo_rapido" value="0">
                                <input type="hidden" id="geracao_desejada_hidden" name="geracao_desejada" value="">
                                <input type="hidden" id="margem_seguranca_hidden" name="margem_seguranca" value="">

                                <div class="row mb-4">

                                    <!-- CIDADE -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Sua cidade
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <?php 
                                        // Use a função gerarCampoCidade do arquivo funcoes.php com o nome correto
                                        $valor_cidade = $ultimo_orcamento ? htmlspecialchars($ultimo_orcamento['cidade_cliente']) : '';
                                        echo '
                                        <div class="position-relative">
                                            <input type="text" name="cidade_cliente" id="cidade-input" class="form-control" 
                                                   value="' . htmlspecialchars($valor_cidade) . '" 
                                                   placeholder="Digite sua cidade" autocomplete="off" required>
                                            <div id="sugestoes-cidade-input" class="list-group position-absolute w-100 sugestoes-cidade" style="display: none;"></div>
                                        </div>
                                        <script>document.addEventListener("DOMContentLoaded", function() { inicializarCampoCidade("cidade-input"); });</script>';
                                        ?>

                                        <div class="invalid-feedback">Informe sua cidade.</div>
                                    </div>

                                    <!-- TELHADO -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Seu telhado
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="telhado_id" id="telhado-select" required onchange="atualizarImagemTelhado()">
                                            <option value="">Selecione</option>
                                            <?php if ($telhados):
                                                $telhados->data_seek(0);
                                                while ($row = $telhados->fetch_assoc()):
                                                    $selected = ($ultimo_orcamento && $row['telhado_id'] == $ultimo_orcamento['telhado_id']) ? 'selected' : '';
                                                    $imagem_base64 = '';
                                                    if (!empty($row['foto_telhado'])) {
                                                        $imagem_base64 = 'data:image/jpeg;base64,' . base64_encode($row['foto_telhado']);
                                                    }
                                            ?>
                                                <option value="<?= $row['telhado_id'] ?>"
                                                        data-imagem="<?= htmlspecialchars($imagem_base64) ?>"
                                                        <?= $selected ?>>
                                                    <?= htmlspecialchars($row['tipo_telhado']) ?>
                                                </option>
                                            <?php endwhile; endif; ?>
                                        </select>

                                        <div class="invalid-feedback">Selecione o tipo de telhado.</div>

                                        <div id="imagem-telhado" class="mt-2 text-center" style="display:none;">
                                            <img src="" alt="Telhado" class="img-fluid rounded" style="max-height:150px;">
                                        </div>
                                    </div>

                                    <!-- TIPO DE FASE -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Tipo de fase
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="fase_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($fases):
                                                $fases->data_seek(0);
                                                while ($row = $fases->fetch_assoc()):
                                                    $selected = ($ultimo_orcamento && $row['fase_id'] == $ultimo_orcamento['fase_id']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $row['fase_id'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($row['tipo_fase']) ?>
                                                </option>
                                            <?php endwhile; endif; ?>
                                        </select>

                                        <div class="invalid-feedback">Selecione a fase elétrica.</div>
                                    </div>

                                    <!-- CONCESSIONÁRIA -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Concessionária
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="concessionaria_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($concessionarias):
                                                $concessionarias->data_seek(0);
                                                while ($row = $concessionarias->fetch_assoc()):
                                                    $selected = ($ultimo_orcamento && $row['concessionaria_id'] == $ultimo_orcamento['concessionaria_id']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $row['concessionaria_id'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($row['nome_concessionaria']) ?>
                                                </option>
                                            <?php endwhile; endif; ?>
                                        </select>

                                        <div class="invalid-feedback">Selecione a concessionária.</div>
                                    </div>

                                    <!-- TARIFA -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Tarifa de Energia (R$/kWh)
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <input type="number" step="0.01" min="0" name="tarifa" class="form-control"
                                            value="<?= $ultimo_orcamento ? $ultimo_orcamento['tarifa'] : '0.85' ?>" required>

                                        <div class="invalid-feedback">Informe a tarifa de energia.</div>
                                    </div>

                                    <!-- TIPO INSTALAÇÃO -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Tipo de Instalação
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="tipo_instalacao" required>
                                            <option value="">Selecione</option>
                                            <option value="Residencial" <?= ($ultimo_orcamento && $ultimo_orcamento['tipo_instalacao'] == 'Residencial') ? 'selected' : '' ?>>Residencial</option>
                                            <option value="Comercial" <?= ($ultimo_orcamento && $ultimo_orcamento['tipo_instalacao'] == 'Comercial') ? 'selected' : '' ?>>Comercial</option>
                                            <option value="Rural" <?= ($ultimo_orcamento && $ultimo_orcamento['tipo_instalacao'] == 'Rural') ? 'selected' : '' ?>>Rural</option>
                                            <option value="Industrial" <?= ($ultimo_orcamento && $ultimo_orcamento['tipo_instalacao'] == 'Industrial') ? 'selected' : '' ?>>Industrial</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- CONSUMO MENSAL -->
                                <div class="table-responsive mb-4">
                                    <label class="form-label">
                                        Consumo Mensal (kWh) - Últimos 12 meses
                                        <?php if ($ultimo_orcamento): ?>
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                style="width: 28px; height: 28px;"
                                                data-bs-toggle="tooltip"
                                                title="Clique para editar"
                                                onclick="destacarCampo(this)">
                                            <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                        </button>
                                        <?php endif; ?>
                                    </label>

                                    <table class="table table-bordered">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Mês</th>
                                                <th>Consumo (kWh)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($meses as $index => $mes): ?>
                                            <tr>
                                                <td><?= $mes ?></td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="consumo_mes[]"
                                                        class="form-control"
                                                        value="<?= $consumos_anteriores[$index] ?>"
                                                        required>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mb-4">
                                    <!-- MARCA INVERSOR -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Marca inversor
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="marca_inversor" required>
                                            <option value="">Selecione</option>
                                            <?php if ($inversores_query && $inversores_query->num_rows > 0):
                                                $inversores_query->data_seek(0);
                                                while ($inversor = $inversores_query->fetch_assoc()):
                                                    $selected = ($ultimo_orcamento && $inversor['marca_inversor'] == $ultimo_orcamento['marca_inversor']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= htmlspecialchars($inversor['marca_inversor']) ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($inversor['marca_inversor']) ?>
                                                </option>
                                            <?php endwhile; endif; ?>
                                        </select>

                                        <div class="invalid-feedback">Selecione a marca do inversor.</div>
                                    </div>

                                    <!-- TIPO PLACAS -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Tipo de placas
                                            <?php if ($ultimo_orcamento): ?>
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm p-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip"
                                                    title="Clique para editar"
                                                    onclick="destacarCampo(this)">
                                                <i class="fas fa-pencil-alt" style="font-size: 13px;"></i>
                                            </button>
                                            <?php endif; ?>
                                        </label>

                                        <select class="form-select" name="placa_id" required>
                                            <option value="">Selecione</option>
                                            <?php if ($placas_query && $placas_query->num_rows > 0):
                                                $placas_query->data_seek(0);
                                                while ($placa = $placas_query->fetch_assoc()):
                                                    $selected = ($ultimo_orcamento && $placa['placa_id'] == $ultimo_orcamento['placa_id']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $placa['placa_id'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($placa['marca_placa']) ?> <?= $placa['potencia_placa'] ?> W
                                                </option>
                                            <?php endwhile; endif; ?>
                                        </select>

                                        <div class="invalid-feedback">Selecione o tipo de placas.</div>
                                    </div>
                                </div>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-lg btn-primary w-50">
                                        <i class="fas fa-calculator me-2"></i>Calcular Orçamento
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Seção marcas e footer-->
    <?php include __DIR__ . '/includes/marcas.php'; ?>
    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>

    <style>
    .form-label {
        font-weight: 600;
    }
    .btn-outline-primary {
        border-width: 2px;
    }
    #sugestoes-cidade {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-top: none;
    }
    #sugestoes-cidade button {
        border: none;
        background: white;
        text-align: left;
        width: 100%;
    }
    #sugestoes-cidade button:hover {
        background: #f8f9fa;
    }
    #imagem-telhado img {
        border: 2px solid #dee2e6;
        padding: 5px;
    }
    .btn-sm {
        padding: 0.15rem 0.4rem;
        font-size: 0.75rem;
    }
    </style>
</body>
</html>