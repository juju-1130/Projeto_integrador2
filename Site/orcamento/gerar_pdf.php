<?php
session_start();
include '../conexao.php';

if (!isset($_GET['id'])) {
    die("Orçamento não especificado.");
}

$orcamento_id = (int)$_GET['id'];

// Busca os dados do orçamento COM DADOS DO INVERSOR
$sql = "SELECT o.*, 
               u.nome_usuario, u.email_usuario, u.telefone_usuario,
               t.tipo_telhado, f.tipo_fase, c.nome_concessionaria,
               p.potencia_placa, p.marca_placa,
               i.marca_inversor, i.potencia_inversor, i.nome_inversor, i.overload
        FROM Orcamento o
        JOIN Usuario u ON o.usuario_id = u.usuario_id
        LEFT JOIN Telhado t ON o.telhado_id = t.telhado_id
        LEFT JOIN Fase f ON o.fase_id = f.fase_id
        LEFT JOIN Concessionaria c ON o.concessionaria_id = c.concessionaria_id
        LEFT JOIN Placa p ON o.placa_id = p.placa_id
        LEFT JOIN Inversor i ON o.inversor_id = i.inversor_id
        WHERE o.orcamento_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro ao preparar consulta: " . $conn->error);
}
$stmt->bind_param("i", $orcamento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Orçamento não encontrado.");
}

$orcamento = $result->fetch_assoc();

// decodificar consumos
$consumo_mensal = json_decode($orcamento['consumo_mensal_json'], true);
if (!is_array($consumo_mensal) || count($consumo_mensal) !== 12) {
    $consumo_mensal = array_fill(0, 12, 0);
}

$meses_completo = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
$meses_abreviado = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

// Dados do inversor
$marca_inversor = htmlspecialchars($orcamento['marca_inversor'] ?? '');
$potencia_inversor = floatval($orcamento['potencia_inversor'] ?? 0.0);
$nome_inversor = htmlspecialchars($orcamento['nome_inversor'] ?? '');
$overload_inversor = floatval($orcamento['overload'] ?? 0.0);

// valores seguros / fallback
$potencia_sistema_kwp = floatval($orcamento['potencia_sistema_kwp'] ?? 0.0);
$quantidade_placas = intval($orcamento['quantidade_placas'] ?? 0);
$potencia_placa_w = intval($orcamento['potencia_placa'] ?? 0);
$marca_placa = htmlspecialchars($orcamento['marca_placa'] ?? '');
$tarifa = floatval($orcamento['tarifa'] ?? 0.0);
$producao_estimada = floatval($orcamento['producao_estimada'] ?? 0.0);

// se producao_estimada não estiver salva, estimamos
if ($producao_estimada <= 0 && $potencia_sistema_kwp > 0) {
    $producao_estimada = $potencia_sistema_kwp * 120.0;
}

// valores financeiros
$valor_total_final = floatval($orcamento['valor_total_final'] ?? 0.0);
$valor_total_custo = floatval($orcamento['valor_total_custo'] ?? $valor_total_final);
$economia_mensal = $producao_estimada * $tarifa;
$economia_anual = $economia_mensal * 12;

// payback (em anos), proteger divisão por zero
$payback = ($economia_anual > 0) ? ($valor_total_final / $economia_anual) : 0;

// area minima aproximada: assumir 1 placa ocupa ~1.7 m2
$area_por_placa_m2 = 1.7;
$area_minima = $quantidade_placas * $area_por_placa_m2;

// para "sobra" (base consumo - geracao)
$base_consumo = floatval($orcamento['consumo_mensal_medio'] ?? 0.0);
$sobra = $producao_estimada - $base_consumo;

// === PREPARAR DADOS PARA O GRÁFICO ===
$dados_grafico = [];
$max_valor = max(max($consumo_mensal), $producao_estimada);
$altura_maxima = 120; // altura máxima do gráfico em pixels

foreach ($consumo_mensal as $i => $consumo) {
    $altura_consumo = ($consumo / $max_valor) * $altura_maxima;
    $altura_geracao = ($producao_estimada / $max_valor) * $altura_maxima;
    
    $dados_grafico[] = [
        'mes' => $meses_abreviado[$i],
        'consumo' => $consumo,
        'geracao' => $producao_estimada,
        'altura_consumo' => $altura_consumo,
        'altura_geracao' => $altura_geracao
    ];
}

// === FUNÇÃO PARA CALCULAR TABELA PRICE ===
function calcularTabelaPrice($valorFinanciamento, $taxaJurosMensal, $numeroParcelas) {
    $i = $taxaJurosMensal / 100;
    $fator = pow(1 + $i, $numeroParcelas);
    $pmt = $valorFinanciamento * (($i * $fator) / ($fator - 1));
    return $pmt;
}

// === CONFIGURAÇÃO DOS JUROS ===
$taxas_juros = [
    24 => 2.0,
    36 => 1.8,  
    48 => 1.6,
    60 => 1.5,
    72 => 1.4
];

// === CALCULAR PARCELAS COM JUROS (TABELA PRICE) ===
$parcelas_com_juros = [];
foreach ($taxas_juros as $meses => $taxa) {
    $valor_parcela = calcularTabelaPrice($valor_total_final, $taxa, $meses);
    $parcelas_com_juros[$meses] = [
        'valor_parcela' => $valor_parcela,
        'taxa_juros' => $taxa,
        'total_pago' => $valor_parcela * $meses,
        'juros_total' => ($valor_parcela * $meses) - $valor_total_final
    ];
}

// Calcular economia
$conta_sem_solar_ano = $base_consumo * $tarifa * 12;
$conta_com_solar_ano = max(0, ($base_consumo - $producao_estimada) * $tarifa * 12);
$economia_total_ano = $conta_sem_solar_ano - $conta_com_solar_ano;

// Calcular dados ecológicos
$arvores_salvas = $producao_estimada * 0.63;
$co2_evitado = $producao_estimada * 0.00036;
$carros_fora = $co2_evitado * 4585; // conversão aproximada

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Orçamento #<?= $orcamento_id ?> — <?= htmlspecialchars($orcamento['nome_usuario'] ?? '') ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { 
            box-sizing: border-box; 
            font-family: "Segoe UI", Arial, sans-serif; 
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        body { 
            margin: 0; 
            padding: 0; 
            color: #222; 
            background: #fff; 
            line-height: 1.4; 
        }
        
        /* Página de capa */
        .cover-page { 
            height: 100vh; 
            background: white; /* FUNDO BRANCO */
            color: #222; /* TEXTO PRETO */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
            border-bottom: 3px solid #007bff; /* BORDA AZUL EMBAIXO PARA DESTAQUE */
        }
        
        .cover-logo { max-width: 200px; margin-bottom: 30px; }
        .cover-title { font-size: 36px; font-weight: 700; margin-bottom: 15px; }
        .cover-subtitle { font-size: 20px; margin-bottom: 30px; opacity: 0.9; }
        .cover-client { font-size: 18px; margin-bottom: 10px; }
        .cover-date { font-size: 14px; opacity: 0.8; }
        
        /* Fases do projeto */
        .fases-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin: 30px 0; 
        }
        
        .fase-card { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 10px; 
            text-align: center;
            border-left: 4px solid #007bff;
        }
        
        .fase-icon { font-size: 24px; margin-bottom: 15px; color: #007bff; }
        
        /* Layout geral */
        .page { padding: 25px; min-height: 100vh; }
        .section { margin-bottom: 30px; }
        .box { border: 1px solid #e0e0e0; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        
        /* Cabeçalhos */
        h1 { color: #007bff; font-size: 24px; margin-bottom: 20px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        h2 { color: #333; font-size: 18px; margin-bottom: 15px; }
        h3 { color: #007bff; font-size: 16px; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }
        
        /* Grid e layout */
        .row { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 15px; }
        .col { flex: 1; min-width: 250px; }
        
        /* Cards e destaques */
        .card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #007bff; }
        .big { font-size: 24px; font-weight: 700; color: #007bff; }
        .green { color: #28a745; }
        .red { color: #dc3545; }
        .muted { color: #6c757d; font-size: 14px; }
        
        /* Tabelas */
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; font-weight: 600; }
        
        /* GRÁFICO - CORREÇÕES PARA IMPRESSÃO */
        .grafico-section { margin: 30px 0; }
        .grafico-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
        }
        .grafico-legenda {
            display: flex;
            gap: 20px;
        }
        .legenda-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }
        .legenda-cor {
            width: 16px;
            height: 16px;
            border-radius: 3px;
            border: 1px solid #000 !important;
        }
        .legenda-geracao { 
            background: #28a745 !important;
        }
        .legenda-consumo { 
            background: #dc3545 !important;
        }
        
        .grafico-container {
            background: #f8f9fa !important;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #dee2e6 !important;
        }
        .grafico-barras {
            display: flex;
            align-items: end;
            justify-content: space-between;
            height: 200px;
            padding: 20px 0;
            position: relative;
        }
        .barra-grupo {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 7%;
            text-align: center;
            position: relative;
        }
        .barra {
            width: 25px;
            border-radius: 4px 4px 0 0;
            position: relative;
            border: 1px solid #000 !important;
        }
        .barra-consumo {
            background: #dc3545 !important;
            margin-bottom: 3px;
        }
        .barra-geracao {
            background: #28a745 !important;
        }
        .mes-label {
            margin-top: 10px;
            font-size: 11px;
            font-weight: 600;
            color: #495057;
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
        }
        .valor-barra {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            font-weight: bold;
            background: white !important;
            padding: 2px 4px;
            border-radius: 3px;
            border: 1px solid #dee2e6 !important;
        }
        
        /* Linha horizontal do gráfico */
        .grafico-linha {
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6 !important;
        }
        
        /* Formas de pagamento */
        .payment-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin: 20px 0; }
        .payment-card { background: white; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; text-align: center; }
        .payment-card.highlight { border-color: #28a745; background: #f8fff9; }
        
        /* Vantagens */
        .vantagens-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
        .vantagem-card { text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px; }
        
        /* Controles de impressão */
        .no-print { text-align: center; margin: 20px; }
        .btn-print { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        .page-break { page-break-after: always; }
        
        /* Ícones profissionais */
        .icon { width: 20px; text-align: center; }
        
        /* ESTILOS ESPECÍFICOS PARA IMPRESSÃO */
        @media print {
            body { 
                margin: 15px;
                padding: 0;
                background: white !important;
                color: black !important;
                font-size: 12pt;
            }
            
            .no-print { 
                display: none !important; 
            }
            
            .page-break { 
                page-break-after: always !important; 
            }
            
            .cover-page { 
                height: 100vh !important;
                background: white !important; 
                color: #222 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* GARANTIR QUE O GRÁFICO APAREÇA NA IMPRESSÃO */
            .grafico-container {
                background: #f8f9fa !important;
                border: 2px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .barra-consumo {
                background: #dc3545 !important;
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .barra-geracao {
                background: #28a745 !important;
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .legenda-geracao {
                background: #28a745 !important;
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .legenda-consumo {
                background: #dc3545 !important;
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .valor-barra {
                background: white !important;
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .grafico-linha {
                background: #dee2e6 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* FORÇAR CORES EM OUTROS ELEMENTOS */
            .payment-card.highlight {
                border-color: #28a745 !important;
                background: #f8fff9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            th {
                background: #007bff !important;
                color: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* MELHORAR QUEBRAS DE PÁGINA */
            .page {
                page-break-inside: avoid;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
        
        /* MELHORIAS VISUAIS PARA TELA */
        @media screen {
            .barra-consumo {
                background: linear-gradient(to top, #dc3545, #e74c3c);
                border: none;
            }
            
            .barra-geracao {
                background: linear-gradient(to top, #28a745, #20c997);
                border: none;
            }
            
            .legenda-geracao,
            .legenda-consumo {
                border: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Imprimir / Salvar como PDF</button>
    </div>

    <!-- PÁGINA 1: CAPA -->
    <div class="cover-page">
        <img src="../images/MKLOGO.png" alt="MK Energia Solar" class="cover-logo">
        <h1 class="cover-title">Estudo de Investimento</h1>
        <h2 class="cover-subtitle">Seu Projeto de Energia Solar</h2>
        <div class="cover-client">
            <strong><?= htmlspecialchars($orcamento['nome_usuario'] ?? '') ?></strong><br>
            <?= htmlspecialchars($orcamento['cidade_cliente'] ?? '') ?>
        </div>
        <div class="cover-date">
            <?= date('d/m/Y') ?> — Proposta #<?= $orcamento_id ?>
        </div>
        <div style="margin-top: 40px; font-size: 16px;">
            <i class="fas fa-phone"></i> (51) 3547-1530 • (51) 99562-2598<br>
            <i class="fas fa-envelope"></i> mkferragenseeletrica@gmail.com
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PÁGINA 2: FASES DO PROJETO -->
    <div class="page">
        <h1><i class="fas fa-rocket"></i> Fases do Projeto</h1>
        
        <div class="fases-grid">
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-drafting-compass"></i></div>
                <h3>Projeto</h3>
                <p>Seu projeto será desenvolvido por nosso time de engenheiros e atenderá todas as exigências normativas.</p>
            </div>
            
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-truck"></i></div>
                <h3>Logística</h3>
                <p>Cuidaremos para que seu equipamento seja entregue com segurança no local da instalação.</p>
            </div>
            
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-tools"></i></div>
                <h3>Instalação</h3>
                <p>Agendaremos a instalação para um momento conveniente a sua rotina.</p>
            </div>
            
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-file-contract"></i></div>
                <h3>Homologação</h3>
                <p>Cuidaremos de toda a papelada da homologação do seu sistema junto a concessionária.</p>
            </div>
            
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Monitoramento</h3>
                <p>Acompanhamos a geração de energia do seu sistema frequentemente para identificar possíveis falhas.</p>
            </div>
            
            <div class="fase-card">
                <div class="fase-icon"><i class="fas fa-cogs"></i></div>
                <h3>Manutenção</h3>
                <p>Conheça nossos planos de manutenção e operação para garantir o máximo desempenho.</p>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PÁGINA 3: DETALHES DO PROJETO -->
    <div class="page">
        <h1><i class="fas fa-chart-bar"></i> SEU PROJETO</h1>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-bolt"></i> Potência do Projeto</h3>
                    <div class="big"><?= number_format($potencia_sistema_kwp, 2, ',', '.') ?> kWp</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-sun"></i> Geração Mensal</h3>
                    <div class="big"><?= number_format($producao_estimada, 0, ',', '.') ?> kWh</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-solar-panel"></i> Painéis Fotovoltaicos</h3>
                    <div><?= $quantidade_placas ?> × <?= $marca_placa ?> <?= $potencia_placa_w ?>W</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-chart-line"></i> Base de consumo</h3>
                    <div><?= number_format($base_consumo, 0, ',', '.') ?> kWh</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-plug"></i> Inversor</h3>
                    <div>1 × <?= $marca_inversor ?> <?= $nome_inversor ?></div>
                    <div class="muted"><?= number_format($potencia_inversor, 1, ',', '.') ?> kW • Overload: <?= number_format($overload_inversor, 1, ',', '.') ?>%</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-balance-scale"></i> Saldo Energético</h3>
                    <div class="<?= $sobra >= 0 ? 'green' : 'red' ?> big"><?= number_format($sobra, 0, ',', '.') ?> kWh</div>
                    <div class="muted"><?= $sobra >= 0 ? 'Sobra' : 'Déficit' ?> mensal</div>
                </div>
            </div>
        </div>
        
        <div class="box">
            <h3><i class="fas fa-home"></i> Estrutura e Área</h3>
            <div class="row">
                <div class="col">
                    <strong>Tipo de Telhado:</strong><br>
                    <?= htmlspecialchars($orcamento['tipo_telhado'] ?? 'Não informado') ?>
                </div>
                <div class="col">
                    <strong>Área Mínima Necessária:</strong><br>
                    <?= number_format($area_minima, 1, ',', '.') ?> m²
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PÁGINA 4: GRÁFICO E ECONOMIA -->
    <div class="page">
        <div class="grafico-section">
            <div class="grafico-header">
                <h1 style="border: none; margin: 0;"><i class="fas fa-chart-bar"></i> GERAÇÃO X CONSUMO</h1>
                <div class="grafico-legenda">
                    <div class="legenda-item">
                        <div class="legenda-cor legenda-geracao"></div>
                        <span>Geração</span>
                    </div>
                    <div class="legenda-item">
                        <div class="legenda-cor legenda-consumo"></div>
                        <span>Consumo</span>
                    </div>
                </div>
            </div>
            
            <div class="grafico-container">
                <div class="grafico-barras">
                    <!-- Linhas de referência -->
                    <div class="grafico-linha" style="top: 25%"></div>
                    <div class="grafico-linha" style="top: 50%"></div>
                    <div class="grafico-linha" style="top: 75%"></div>
                    
                    <?php foreach ($dados_grafico as $dado): ?>
                    <div class="barra-grupo">
                        <div class="barra barra-geracao" style="height: <?= $dado['altura_geracao'] ?>px;">
                            <div class="valor-barra"><?= number_format($dado['geracao'], 0, ',', '.') ?></div>
                        </div>
                        <div class="barra barra-consumo" style="height: <?= $dado['altura_consumo'] ?>px;">
                            <div class="valor-barra"><?= number_format($dado['consumo'], 0, ',', '.') ?></div>
                        </div>
                        <div class="mes-label"><?= $dado['mes'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-money-bill-wave"></i> SUA ECONOMIA</h3>
                    <div class="muted">Sua conta de energia sem Energia Solar</div>
                    <div class="big">R$ <?= number_format($conta_sem_solar_ano, 2, ',', '.') ?> / ano</div>
                    <div class="muted">R$ <?= number_format($conta_sem_solar_ano / 12, 2, ',', '.') ?> / mês</div>
                    
                    <div style="margin: 15px 0; border-top: 1px dashed #dee2e6; padding-top: 15px;">
                        <div class="muted">Sua conta de energia com Energia Solar</div>
                        <div>R$ <?= number_format($conta_com_solar_ano, 2, ',', '.') ?> / ano</div>
                        <div class="muted">R$ <?= number_format($conta_com_solar_ano / 12, 2, ',', '.') ?> / mês</div>
                    </div>
                    
                    <div style="background: #d4edda; padding: 10px; border-radius: 5px; text-align: center;">
                        <div class="muted">SUA ECONOMIA SERÁ DE:</div>
                        <div class="big green">R$ <?= number_format($economia_total_ano, 2, ',', '.') ?> / ano</div>
                        <div class="green">R$ <?= number_format($economia_total_ano / 12, 2, ',', '.') ?> / mês</div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-chart-line"></i> RETORNO DE INVESTIMENTO</h3>
                    <div class="muted">PayBack</div>
                    <div class="big"><?= number_format($payback, 2, ',', '.') ?> anos</div>
                    
                    <div style="margin: 15px 0; border-top: 1px dashed #dee2e6; padding-top: 15px;">
                        <div class="muted">Economia anual</div>
                        <div class="big green">R$ <?= number_format($economia_total_ano, 2, ',', '.') ?></div>
                    </div>
                    
                    <div style="background: #e7f3ff; padding: 10px; border-radius: 5px;">
                        <div class="muted">Taxa Interna de Retorno (TIR)</div>
                        <div class="big" style="color: #007bff;">48,01%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PÁGINA 5: PAGAMENTO E VANTAGENS -->
    <div class="page">
        <h1><i class="fas fa-money-bill-wave"></i> FORMA DE PAGAMENTO</h1>
        
        <div class="payment-cards">
            <div class="payment-card highlight">
                <div class="muted">Valor à vista</div>
                <div class="big">R$ <?= number_format($valor_total_final, 2, ',', '.') ?></div>
                <div class="muted" style="font-size: 12px;">Sem juros</div>
            </div>
            
            <?php foreach($parcelas_com_juros as $meses => $dados): ?>
            <div class="payment-card">
                <div class="muted"><?= $meses ?>x</div>
                <div class="big">R$ <?= number_format($dados['valor_parcela'], 2, ',', '.') ?></div>
                <div class="muted" style="font-size: 11px;">
                    Total: R$ <?= number_format($dados['total_pago'], 2, ',', '.') ?><br>
                    Juros: <?= number_format($dados['taxa_juros'], 1, ',', '.') ?>% a.m.
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="box">
            <div class="muted" style="text-align: center; font-style: italic;">
                Simulação sujeita a análise de crédito conforme a instituição financeira escolhida
            </div>
        </div>
        
        <h1><i class="fas fa-shield-alt"></i> GARANTIAS</h1>
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-solar-panel"></i> Painéis Fotovoltaicos</h3>
                    <div>25 anos de eficiência</div>
                    <div class="muted">12 anos para defeito de fabricação</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-plug"></i> Inversores</h3>
                    <div>7 a 10 anos</div>
                    <div class="muted">Conforme fabricante</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-tools"></i> Instalação</h3>
                    <div>12 meses</div>
                    <div class="muted">Garantia do serviço</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3><i class="fas fa-home"></i> Estrutura</h3>
                    <div>10 anos</div>
                    <div class="muted">Resistência e durabilidade</div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PÁGINA 6: ECOLÓGICO E VANTAGENS -->
    <div class="page">
        <h1><i class="fas fa-leaf"></i> RESULTADO ECOLÓGICO</h1>
        
        <div class="row">
            <div class="col">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 10px; color: #28a745;"><i class="fas fa-tree"></i></div>
                    <div class="big"><?= number_format($arvores_salvas, 0, ',', '.') ?></div>
                    <div class="muted">Árvores Salvas</div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 10px; color: #6c757d;"><i class="fas fa-car"></i></div>
                    <div class="big"><?= number_format($carros_fora, 0, ',', '.') ?></div>
                    <div class="muted">anos de um carro fora de circulação</div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 10px; color: #17a2b8;"><i class="fas fa-globe-americas"></i></div>
                    <div class="big"><?= number_format($co2_evitado, 1, ',', '.') ?></div>
                    <div class="muted">toneladas de CO₂ não emitidos</div>
                </div>
            </div>
        </div>
        
        <h1><i class="fas fa-star"></i> VANTAGENS</h1>
        <div class="vantagens-grid">
            <div class="vantagem-card">
                <div style="font-size: 40px; margin-bottom: 15px; color: #007bff;"><i class="fas fa-bullseye"></i></div>
                <h3>SOLUÇÕES COMPLETAS</h3>
                <p>Projeto, instalação e homologação em um só lugar</p>
            </div>
            <div class="vantagem-card">
                <div style="font-size: 40px; margin-bottom: 15px; color: #28a745;"><i class="fas fa-award"></i></div>
                <h3>QUALIDADE</h3>
                <p>Equipamentos das melhores marcas do mercado</p>
            </div>
            <div class="vantagem-card">
                <div style="font-size: 40px; margin-bottom: 15px; color: #ffc107;"><i class="fas fa-chart-line"></i></div>
                <h3>ACOMPANHAMENTO</h3>
                <p>Monitoramento contínuo do seu sistema</p>
            </div>
            <div class="vantagem-card">
                <div style="font-size: 40px; margin-bottom: 15px; color: #dc3545;"><i class="fas fa-headset"></i></div>
                <h3>PÓS VENDAS</h3>
                <p>Suporte técnico especializado sempre que precisar</p>
            </div>
        </div>
        
        <div class="box" style="margin-top: 30px; background: #f8f9fa;">
            <div style="text-align: center;">
                <h3><i class="fas fa-phone"></i> Entre em Contato</h3>
                <div style="font-size: 18px; margin: 10px 0;">
                    <strong>MK Energia Solar</strong><br>
                    <i class="fas fa-phone"></i> (51) 3547-1530 • (51) 99822-4220<br>
                    <i class="fas fa-envelope"></i> mkferragenseeletrica@gmail.com
                </div>
                <div class="muted">
                    Documento gerado em: <?= date('d/m/Y H:i') ?> — Proposta #<?= $orcamento_id ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>