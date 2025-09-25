<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/head.php'; ?>
    <body id="page-top">
        <!-- Navigation-->
        <?php 
        include __DIR__ . '/../includes/navbar.php'; 
        
        $orcamentos = [
            [
                'id' => 1,
                'titulo' => 'Sistema Fotovoltaico 7,5kWp',
                'descricao' => 'Sistema fotovoltaico com 18 painéis 610W e 1 inversor monofásico 7,5kw',
                'arquivo' => '../images/orcamento.pdf',
                'data' => '15/10/2023',
                'valor' => 'R$ 28.450,00',
            ],
            [
                'id' => 2,
                'titulo' => 'Sistema Fotovoltaico 15kWp',
                'descricao' => 'Sistema para comércio com 42 painéis e 1 inversor trifásico 15kw',
                'arquivo' => '../images/orcamento.pdf',
                'data' => '18/10/2023',
                'valor' => 'R$ 79.800,00',
            ],
        ];
        
        $whatsapp_number = "5551998224220";
        
        ?>
        
        <!--Seção bem vindo-->
        <?php 
        include __DIR__ . '/../includes/funcoes.php'; 
        echo gerarTituloPagina("Meus Orçamentos"); 
        ?>

        <section class="page-section" id="meus-orcamentos">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <?php if (count($orcamentos) > 0): ?>
                            <?php foreach ($orcamentos as $orcamento): 
                                // Criar mensagem pré-definida para WhatsApp
                                $whatsapp_message = rawurlencode("Olá! Gostaria de tirar dúvidas sobre o orçamento #MK" . str_pad($orcamento['id'], 4, '0', STR_PAD_LEFT) . " - " . $orcamento['titulo']);
                                $whatsapp_link = "https://wa.me/{$whatsapp_number}?text={$whatsapp_message}";
                            ?>
                                <div class="card shadow p-4 mb-5 orcamento-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="text-primary mb-0"><?php echo $orcamento['titulo']; ?></h4>
                                            <p class="text-muted mb-0 mt-1"><?php echo $orcamento['descricao']; ?></p>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-muted small"><?php echo $orcamento['data']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded">
                                                <strong>Valor do Projeto:</strong> 
                                                <span class="text-success"><?php echo $orcamento['valor']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded">
                                                <strong>Número do Orçamento:</strong> 
                                                <span>#MK<?php echo str_pad($orcamento['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <embed src="<?php echo $orcamento['arquivo']; ?>#toolbar=0&navpanes=0&scrollbar=0" 
                                           type="application/pdf" 
                                           class="w-100 rounded border mb-3" 
                                           style="height: 75vh;">
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="<?php echo $whatsapp_link; ?>" target="_blank" class="btn btn-primary">
                                                <i class="fab fa-whatsapp me-2"></i>Tirar Dúvidas via WhatsApp
                                            </a>
                                        </div>
                                        <div>
                                            <a href="<?php echo $orcamento['arquivo']; ?>" 
                                               download="Orçamento_MK<?php echo str_pad($orcamento['id'], 4, '0', STR_PAD_LEFT); ?>.pdf" 
                                               class="btn btn-outline-success btn-download">
                                                <i class="fas fa-download me-2"></i>Salvar PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card shadow p-5 text-center">
                                <div class="empty-state">
                                    <i class="fas fa-file-pdf"></i>
                                    <h3>Nenhum orçamento encontrado</h3>
                                    <p class="mb-4">Você ainda não possui orçamentos gerados.</p>
                                    <a href="contato.php" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i>Solicitar Primeiro Orçamento
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (count($orcamentos) > 0): ?>
                        <div class="text-center mt-4">
                            <a href="contato.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i>Solicitar Visita
                            </a>
                        </div>
                        <?php endif; ?>
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