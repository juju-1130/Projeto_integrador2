<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Orçamento #<?= $orcamento_id ?> - <?= htmlspecialchars($orcamento['nome_usuario'] ?? '') ?></title>
    <style>
        /* ESTILO SIMPLIFICADO PARA PDF - SEM ÍCONES, SEM FASES */
        * { 
            box-sizing: border-box; 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 0;
        }
        
        body { 
            color: #222; 
            background: #fff; 
            line-height: 1.3;
            font-size: 12px;
        }
        
        .page { 
            padding: 20px; 
            page-break-after: always;
        }
        
        .cover-page { 
            text-align: center;
            padding: 100px 20px;
            border-bottom: 3px solid #007bff;
        }
        
        .cover-logo { max-width: 150px; margin-bottom: 20px; }
        .cover-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; color: #007bff; }
        .cover-subtitle { font-size: 16px; margin-bottom: 20px; }
        .cover-client { font-size: 14px; margin-bottom: 8px; }
        .cover-date { font-size: 12px; color: #666; }
        
        h1 { 
            color: #007bff; 
            font-size: 16px; 
            margin-bottom: 15px; 
            border-bottom: 1px solid #007bff; 
            padding-bottom: 5px; 
        }
        
        h2 { color: #333; font-size: 14px; margin-bottom: 10px; }
        h3 { color: #007bff; font-size: 13px; margin-bottom: 8px; }
        
        .card { 
            background: #f8f9fa; 
            padding: 12px; 
            border-radius: 5px; 
            border-left: 3px solid #007bff;
            margin-bottom: 10px;
        }
        
        .big { font-size: 18px; font-weight: bold; color: #007bff; }
        .green { color: #28a745; }
        .red { color: #dc3545; }
        .muted { color: #6c757d; font-size: 11px; }
        
        /* LAYOUT SIMPLES COM FLOAT */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        .col {
            float: left;
            width: 48%;
            margin-right: 2%;
        }
        
        .col:last-child {
            margin-right: 0;
        }
        
        /* GRÁFICO SIMPLIFICADO */
        .grafico-section {
            margin: 20px 0;
        }
        
        .grafico-container {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .grafico-barras {
            height: 150px;
            position: relative;
            border-bottom: 1px solid #ccc;
        }
        
        .barra-grupo {
            position: absolute;
            bottom: 0;
            width: 6%;
            text-align: center;
        }
        
        .barra {
            width: 15px;
            margin: 0 auto 2px auto;
            border: 1px solid #000;
        }
        
        .barra-consumo {
            background: #dc3545;
            height: 40px;
        }
        
        .barra-geracao {
            background: #28a745;
            height: 80px;
        }
        
        .mes-label {
            font-size: 9px;
            margin-top: 3px;
        }
        
        /* FORMAS DE PAGAMENTO */
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        
        .payment-table .highlight {
            background: #f8fff9;
            border-color: #28a745;
        }
        
        /* TABELAS */
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
            background: #007bff;
            color: white;
        }
        
        /* CONTATO */
        .contato-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 3px solid #007bff;
        }
    </style>
</head>
<body>

    <!-- PÁGINA 1: CAPA -->
    <div class="page cover-page">
        <div class="cover-title">Estudo de Investimento</div>
        <div class="cover-subtitle">Seu Projeto de Energia Solar</div>
        <div class="cover-client">
            <strong><?= htmlspecialchars($orcamento['nome_usuario'] ?? '') ?></strong><br>
            <?= htmlspecialchars($orcamento['cidade_cliente'] ?? '') ?>
        </div>
        <div class="cover-date">
            <?= date('d/m/Y') ?> — Proposta #<?= $orcamento_id ?>
        </div>
        <div style="margin-top: 30px; font-size: 12px;">
            (51) 3547-1530 • (51) 99822-4220<br>
            mkferragenseeletrica@gmail.com
        </div>
    </div>

    <!-- PÁGINA 2: DETALHES DO PROJETO -->
    <div class="page">
        <h1>DETALHES DO PROJETO</h1>
        
        <div class="clearfix">
            <div class="col">
                <div class="card">
                    <h3>Potência do Projeto</h3>
                    <div class="big"><?= number_format($potencia_sistema_kwp, 2, ',', '.') ?> kWp</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3>Geração Mensal</h3>
                    <div class="big"><?= number_format($producao_estimada, 0, ',', '.') ?> kWh</div>
                </div>
            </div>
        </div>
        
        <div class="clearfix">
            <div class="col">
                <div class="card">
                    <h3>Painéis Fotovoltaicos</h3>
                    <div><?= $quantidade_placas ?> × <?= $marca_placa ?> <?= $potencia_placa_w ?>W</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3>Base de consumo</h3>
                    <div><?= number_format($base_consumo, 0, ',', '.') ?> kWh</div>
                </div>
            </div>
        </div>
        
        <div class="clearfix">
            <div class="col">
                <div class="card">
                    <h3>Inversor</h3>
                    <div>1 × <?= $marca_inversor ?> <?= $nome_inversor ?></div>
                    <div class="muted"><?= number_format($potencia_inversor, 1, ',', '.') ?> kW • Overload: <?= number_format($overload_inversor, 1, ',', '.') ?>%</div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <h3>Saldo Energético</h3>
                    <div class="<?= $sobra >= 0 ? 'green' : 'red' ?> big"><?= number_format($sobra, 0, ',', '.') ?> kWh</div>
                    <div class="muted"><?= $sobra >= 0 ? 'Sobra' : 'Déficit' ?> mensal</div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h3>Estrutura e Área</h3>
            <div class="clearfix">
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

    <!-- PÁGINA 3: GRÁFICO E ECONOMIA -->
    <div class="page">
        <h1>GERAÇÃO X CONSUMO</h1>
        
        <div class="grafico-section">
            <div class="grafico-container">
                <div class="grafico-barras">
                    <?php 
                    $left_position = 3;
                    foreach ($dados_grafico as $dado): 
                    ?>
                    <div class="barra-grupo" style="left: <?= $left_position ?>%;">
                        <div class="barra barra-geracao" style="height: <?= $dado['altura_geracao'] ?>px;"></div>
                        <div class="barra barra-consumo" style="height: <?= $dado['altura_consumo'] ?>px;"></div>
                        <div class="mes-label"><?= $dado['mes'] ?></div>
                    </div>
                    <?php 
                    $left_position += 8;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
        
        <div class="clearfix">
            <div class="col">
                <div class="card">
                    <h3>SUA ECONOMIA</h3>
                    <div class="muted">Sua conta de energia sem Energia Solar</div>
                    <div class="big">R$ <?= number_format($conta_sem_solar_ano, 2, ',', '.') ?> / ano</div>
                    <div class="muted">R$ <?= number_format($conta_sem_solar_ano / 12, 2, ',', '.') ?> / mês</div>
                    
                    <div style="margin: 10px 0; border-top: 1px dashed #dee2e6; padding-top: 10px;">
                        <div class="muted">Sua conta de energia com Energia Solar</div>
                        <div>R$ <?= number_format($conta_com_solar_ano, 2, ',', '.') ?> / ano</div>
                        <div class="muted">R$ <?= number_format($conta_com_solar_ano / 12, 2, ',', '.') ?> / mês</div>
                    </div>
                    
                    <div style="background: #d4edda; padding: 8px; border-radius: 3px; text-align: center;">
                        <div class="muted">SUA ECONOMIA SERÁ DE:</div>
                        <div class="big green">R$ <?= number_format($economia_total_ano, 2, ',', '.') ?> / ano</div>
                        <div class="green">R$ <?= number_format($economia_total_ano / 12, 2, ',', '.') ?> / mês</div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card">
                    <h3>RETORNO DE INVESTIMENTO</h3>
                    <div class="muted">PayBack</div>
                    <div class="big"><?= number_format($payback, 2, ',', '.') ?> anos</div>
                    
                    <div style="margin: 10px 0; border-top: 1px dashed #dee2e6; padding-top: 10px;">
                        <div class="muted">Economia anual</div>
                        <div class="big green">R$ <?= number_format($economia_total_ano, 2, ',', '.') ?></div>
                    </div>
                    
                    <div style="background: #e7f3ff; padding: 8px; border-radius: 3px;">
                        <div class="muted">Taxa Interna de Retorno (TIR)</div>
                        <div class="big" style="color: #007bff;">48,01%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PÁGINA 4: PAGAMENTO E GARANTIAS -->
    <div class="page">
        <h1>FORMA DE PAGAMENTO</h1>
        
        <table class="payment-table">
            <tr>
                <td class="highlight">
                    <div class="muted">Valor à vista</div>
                    <div class="big">R$ <?= number_format($valor_total_final, 2, ',', '.') ?></div>
                    <div class="muted">Sem juros</div>
                </td>
                <?php foreach($parcelas_com_juros as $meses => $dados): ?>
                <td>
                    <div class="muted"><?= $meses ?>x</div>
                    <div class="big">R$ <?= number_format($dados['valor_parcela'], 2, ',', '.') ?></div>
                    <div class="muted">
                        Total: R$ <?= number_format($dados['total_pago'], 2, ',', '.') ?><br>
                        Juros: <?= number_format($dados['taxa_juros'], 1, ',', '.') ?>% a.m.
                    </div>
                </td>
                <?php endforeach; ?>
            </tr>
        </table>
        
        <div style="text-align: center; font-style: italic; margin: 10px 0;">
            Simulação sujeita a análise de crédito conforme a instituição financeira escolhida
        </div>
        
        <h1>GARANTIAS</h1>
        
        <table>
            <tr>
                <th>Componente</th>
                <th>Garantia</th>
                <th>Detalhes</th>
            </tr>
            <tr>
                <td><strong>Painéis Fotovoltaicos</strong></td>
                <td>25 anos</td>
                <td>12 anos para defeito de fabricação</td>
            </tr>
            <tr>
                <td><strong>Inversores</strong></td>
                <td>7 a 10 anos</td>
                <td>Conforme fabricante</td>
            </tr>
            <tr>
                <td><strong>Instalação</strong></td>
                <td>12 meses</td>
                <td>Garantia do serviço</td>
            </tr>
            <tr>
                <td><strong>Estrutura</strong></td>
                <td>10 anos</td>
                <td>Resistência e durabilidade</td>
            </tr>
        </table>
    </div>

    <!-- PÁGINA 5: ECOLÓGICO E CONTATO -->
    <div class="page">
        <h1>RESULTADO ECOLÓGICO</h1>
        
        <table>
            <tr>
                <td style="text-align: center; width: 33%;">
                    <div class="big"><?= number_format($arvores_salvas, 0, ',', '.') ?></div>
                    <div class="muted">Árvores Salvas</div>
                </td>
                <td style="text-align: center; width: 33%;">
                    <div class="big"><?= number_format($carros_fora, 0, ',', '.') ?></div>
                    <div class="muted">anos de um carro fora de circulação</div>
                </td>
                <td style="text-align: center; width: 33%;">
                    <div class="big"><?= number_format($co2_evitado, 1, ',', '.') ?></div>
                    <div class="muted">toneladas de CO₂ não emitidos</div>
                </td>
            </tr>
        </table>
        
        <h1>VANTAGENS</h1>
        
        <div class="info-box">
            <h3>SOLUÇÕES COMPLETAS</h3>
            <p>Projeto, instalação e homologação em um só lugar</p>
        </div>
        
        <div class="info-box">
            <h3>QUALIDADE</h3>
            <p>Equipamentos das melhores marcas do mercado</p>
        </div>
        
        <div class="info-box">
            <h3>ACOMPANHAMENTO</h3>
            <p>Monitoramento contínuo do seu sistema</p>
        </div>
        
        <div class="info-box">
            <h3>PÓS VENDAS</h3>
            <p>Suporte técnico especializado sempre que precisar</p>
        </div>
        
        <div class="contato-box">
            <h3>Entre em Contato</h3>
            <div style="margin: 10px 0;">
                <strong>MK Energia Solar</strong><br>
                (51) 3547-1530 • (51) 99822-4220<br>
                mkferragenseeletrica@gmail.com
            </div>
            <div class="muted">
                Documento gerado em: <?= date('d/m/Y H:i') ?> — Proposta #<?= $orcamento_id ?>
            </div>
        </div>
    </div>

</body>
</html>