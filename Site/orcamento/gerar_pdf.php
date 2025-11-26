<?php
// gerar_pdf.php
session_start();
include '../conexao.php';

// Verificar se é para gerar PDF ou mostrar HTML
$gerar_pdf = isset($_GET['pdf']) && $_GET['pdf'] == 'true';

if (!isset($_GET['id'])) {
    die("Orçamento não especificado.");
}

$orcamento_id = (int)$_GET['id'];

// Busca os dados do orçamento
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

// Se for para gerar PDF, usar dompdf
if ($gerar_pdf) {
    // Incluir dompdf
    require_once '../vendor/autoload.php';
    
    // Configurar dompdf
    $options = new Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Arial');
    $options->set('isPhpEnabled', true);
    
    $dompdf = new Dompdf\Dompdf($options);
    
    // Capturar o HTML
    ob_start();
    $gerando_pdf = true;
    include 'orcamento_template_pdf.php'; // Usar template específico para PDF
    $html = ob_get_clean();
    
    // Carregar HTML no dompdf
    $dompdf->loadHtml($html, 'UTF-8');
    
    // Configurar papel e orientação
    $dompdf->setPaper('A4', 'portrait');
    
    // Renderizar PDF
    $dompdf->render();
    
    // Gerar nome do arquivo
    $filename = "orcamento_{$orcamento_id}_" . preg_replace('/[^a-zA-Z0-9]/', '_', $orcamento['nome_usuario']) . "_" . date('Y-m-d') . ".pdf";
    
    // Output do PDF para o navegador
    $dompdf->stream($filename, [
        'Attachment' => true,
        'compress' => true
    ]);
    
    exit;
}

// Se não for PDF, mostrar HTML normal
include 'orcamento_template.php';
?>