<?php
session_start();
include '../conexao.php';

if (!isset($_GET['id'])) {
    die("Orçamento não especificado.");
}

$orcamento_id = (int)$_GET['id'];

// Busca os dados do orçamento
$sql = "SELECT o.*, 
               u.nome_usuario, u.email_usuario, u.telefone_usuario,
               t.tipo_telhado, f.tipo_fase, c.nome_concessionaria,
               i.marca_inversor, p.potencia_placa
        FROM Orcamento o
        JOIN Usuario u ON o.usuario_id = u.usuario_id
        LEFT JOIN Telhado t ON o.telhado_id = t.telhado_id
        LEFT JOIN Fase f ON o.fase_id = f.fase_id
        LEFT JOIN Concessionaria c ON o.concessionaria_id = c.concessionaria_id
        LEFT JOIN Inversor i ON o.inversor_id = i.inversor_id
        LEFT JOIN Placa p ON o.placa_id = p.placa_id
        WHERE o.orcamento_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orcamento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Orçamento não encontrado.");
}

$orcamento = $result->fetch_assoc();
$consumo_mensal = json_decode($orcamento['consumo_mensal_json'], true);
$meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
$meses_completo = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

// Dados para gráficos
$dados_consumo = array_values($consumo_mensal);
$max_consumo = max($dados_consumo);
$producao_estimada = $orcamento['potencia_sistema_kwp'] * 4.5 * 30 * 0.8; // Estimativa simplificada
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Orçamento MK Energia Solar</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .charts-container { page-break-inside: avoid; }
        }
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo { 
            max-width: 150px; 
            margin-bottom: 10px;
        }
        h1 { 
            color: #0066cc; 
            margin: 0;
        }
        .section { 
            margin-bottom: 25px; 
            page-break-inside: avoid;
        }
        .section-title { 
            color: #0066cc; 
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .row { 
            display: flex; 
            margin-bottom: 5px;
        }
        .label { 
            width: 250px; 
            font-weight: bold;
        }
        .value { 
            flex: 1;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
        }
        th { 
            background-color: #0066cc; 
            color: white;
        }
        .total { 
            font-weight: bold; 
            color: #228b22; 
            font-size: 18px;
        }
        .footer { 
            text-align: center; 
            margin-top: 40px;
            font-style: italic;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .btn-print {
            background: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }
        .chart-wrapper {
            flex: 1;
            min-width: 300px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            color: #0066cc;
        }
        .info-box {
            background: #e8f4ff;
            border-left: 4px solid #0066cc;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .highlight {
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center;">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir ou Salvar como PDF</button>
        <p>Use o comando de impressão do navegador para salvar como PDF</p>
    </div>

    <div class="header">
        <img src="../images/MKLOGO.png" alt="MK Energia Solar" class="logo">
        <h1>Orçamento de Energia Solar</h1>
        <p><strong>Data:</strong> <?= date('d/m/Y H:i') ?></p>
    </div>

    <!-- Dados do Cliente -->
    <div class="section">
        <div class="section-title">Dados do Cliente</div>
        <div class="row"><div class="label">Nome:</div><div class="value"><?= htmlspecialchars($orcamento['nome_usuario']) ?></div></div>
        <div class="row"><div class="label">E-mail:</div><div class="value"><?= htmlspecialchars($orcamento['email_usuario']) ?></div></div>
        <div class="row"><div class="label">Telefone:</div><div class="value"><?= htmlspecialchars($orcamento['telefone_usuario']) ?></div></div>
        <div class="row"><div class="label">Cidade:</div><div class="value"><?= htmlspecialchars($orcamento['cidade_cliente']) ?></div></div>
    </div>

    <!-- Especificações Técnicas -->
    <div class="section">
        <div class="section-title">Especificações Técnicas do Sistema</div>
        <div class="row"><div class="label">Potência do Sistema:</div><div class="value"><?= number_format($orcamento['potencia_sistema_kwp'], 2, ',', '.') ?> kWp</div></div>
        <div class="row"><div class="label">Quantidade de Placas:</div><div class="value"><?= $orcamento['quantidade_placas'] ?> unidades</div></div>
        <div class="row"><div class="label">Potência por Placa:</div><div class="value"><?= htmlspecialchars($orcamento['potencia_placa']) ?> W</div></div>
        <div class="row"><div class="label">Marca do Inversor:</div><div class="value"><?= htmlspecialchars($orcamento['marca_inversor']) ?></div></div>
        
        <!-- NOVA INFORMAÇÃO: Potência mínima do inversor -->
        <!-- NOVA INFORMAÇÃO: Potência mínima do inversor -->
        <div class="highlight">
            <div class="row">
                <div class="label">💡 Potência Mínima do Inversor:</div>
                <div class="value">
                    <strong><?= number_format($orcamento['potencia_inversor_minima'], 2, ',', '.') ?> kW</strong>
                    <small style="display: block; color: #666;">(Recomendado: 80% da potência do sistema)</small>
                </div>
            </div>
        </div>
        
        <div class="row"><div class="label">Tipo de Telhado:</div><div class="value"><?= htmlspecialchars($orcamento['tipo_telhado']) ?></div></div>
        <div class="row"><div class="label">Tipo de Fase:</div><div class="value"><?= htmlspecialchars($orcamento['tipo_fase']) ?></div></div>
        <div class="row"><div class="label">Concessionária:</div><div class="value"><?= htmlspecialchars($orcamento['nome_concessionaria']) ?></div></div>
    </div>

    <!-- Gráficos -->
    <div class="section">
        <div class="section-title">Análise de Consumo e Produção</div>
        
        <div class="charts-container">
            <!-- Gráfico 1: Consumo Mensal -->
            <div class="chart-wrapper">
                <div class="chart-title">Consumo Mensal de Energia (kWh)</div>
                <canvas id="consumoChart" width="400" height="250"></canvas>
            </div>

            <!-- Gráfico 2: Comparação Consumo vs Produção -->
            <div class="chart-wrapper">
                <div class="chart-title">Consumo vs Produção Estimada</div>
                <canvas id="comparacaoChart" width="400" height="250"></canvas>
            </div>
        </div>

        <!-- Informações de Economia -->
        <div class="info-box">
            <h4>💰 Projeção de Economia</h4>
            <div class="row"><div class="label">Produção Mensal Estimada:</div><div class="value"><?= number_format($producao_estimada, 0, ',', '.') ?> kWh/mês</div></div>
            <div class="row"><div class="label">Economia Mensal Estimada:</div><div class="value">R$ <?= number_format($producao_estimada * $orcamento['tarifa'], 2, ',', '.') ?>/mês</div></div>
            <div class="row"><div class="label">Economia Anual Estimada:</div><div class="value">R$ <?= number_format($producao_estimada * $orcamento['tarifa'] * 12, 2, ',', '.') ?>/ano</div></div>
            <div class="row"><div class="label">Payback Estimado:</div><div class="value"><?= number_format($orcamento['valor_total_final'] / ($producao_estimada * $orcamento['tarifa'] * 12), 1, ',', '.') ?> anos</div></div>
        </div>
    </div>

    <!-- Tabela de Consumo Detalhado -->
    <div class="section">
        <div class="section-title">Consumo Mensal Detalhado (kWh)</div>
        <table>
            <thead>
                <tr>
                    <th>Mês</th>
                    <th>Consumo</th>
                    <th>Produção Estimada</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $produção_mensal = $producao_estimada;
                foreach ($consumo_mensal as $index => $valor): 
                    $saldo = $produção_mensal - $valor;
                ?>
                <tr>
                    <td><?= $meses_completo[$index] ?></td>
                    <td><?= number_format($valor, 0, ',', '.') ?></td>
                    <td><?= number_format($produção_mensal, 0, ',', '.') ?></td>
                    <td style="color: <?= $saldo >= 0 ? '#228b22' : '#dc3545' ?>;">
                        <?= number_format($saldo, 0, ',', '.') ?> kWh
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Resumo Financeiro (SEM MARGEM) -->
    <div class="section">
        <div class="section-title">Investimento</div>
        <div class="row"><div class="label">Tarifa de Energia:</div><div class="value">R$ <?= number_format($orcamento['tarifa'], 2, ',', '.') ?></div></div>
        <div class="row"><div class="label">Consumo Médio Mensal:</div><div class="value"><?= number_format($orcamento['consumo_mensal_medio'], 0, ',', '.') ?> kWh</div></div>
        <div class="row total"><div class="label">Valor do Sistema:</div><div class="value">R$ <?= number_format($orcamento['valor_total_final'], 2, ',', '.') ?></div></div>
        
        <!-- REMOVIDO: Margem aplicada -->
    </div>

    <?php if (!empty($orcamento['observacoes'])): ?>
    <div class="section">
        <div class="section-title">Observações</div>
        <p><?= nl2br(htmlspecialchars($orcamento['observacoes'])) ?></p>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>MK Energia Solar • (51) 99822-4220 • mkferragenseeletrica@gmail.com</p>
        <p>Agradecemos a sua preferência!</p>
    </div>

    <script>
        // Gráfico de Consumo Mensal
        const consumoCtx = document.getElementById('consumoChart').getContext('2d');
        new Chart(consumoCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($meses) ?>,
                datasets: [{
                    label: 'Consumo (kWh)',
                    data: <?= json_encode($dados_consumo) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'kWh'
                        }
                    }
                }
            }
        });

        // Gráfico de Comparação
        const comparacaoCtx = document.getElementById('comparacaoChart').getContext('2d');
        const producaoData = Array(12).fill(<?= number_format($producao_estimada, 0) ?>);
        
        new Chart(comparacaoCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($meses) ?>,
                datasets: [
                    {
                        label: 'Consumo Real',
                        data: <?= json_encode($dados_consumo) ?>,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Produção Estimada',
                        data: producaoData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'kWh'
                        }
                    }
                }
            }
        });

        // Auto-print se preferir (descomente a linha abaixo)
        // window.onload = function() { setTimeout(() => window.print(), 1000); }
    </script>
</body>
</html>