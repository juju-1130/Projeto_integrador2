<?php
session_start();
require 'conexao.php';

$is_admin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1;

function buscarVendedores($conn) {
    $sql = "SELECT * FROM Vendedor ORDER BY nome_vendedor";
    
    $result = $conn->query($sql);
    $vendedores = [];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vendedores[] = [
                'id' => $row['vendedor_id'],
                'nome' => $row['nome_vendedor'],
                'cargo' => $row['cargo'],
                'descricao' => $row['descricao'],
                'telefone' => $row['telefone_vendedor'],
                'link' => $row['link_vendedor'],
                'foto' => $row['foto_vendedor'] ? 'admin_php/uploads/vendedores/' . $row['foto_vendedor'] : 'images/icone.png'
            ];
        }
    }
    return $vendedores;
}

$vendedores = buscarVendedores($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    
    <body id="page-top">
        <?php 
            $pagina_parametros = [
                'vendedor.php' => $is_admin ? ['editar_dados'] : [],
            ];
            include __DIR__ . '/includes/navbar.php';
        ?>
        
        <!--Seção titulo-->
        <?php include __DIR__ . '/includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina($is_admin ? "Gerenciar Vendedores" : "Nossa Equipe"); ?>

        <?php if ($is_admin): ?>
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="vendedor.php?modal=novo_vendedor" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Novo Vendedor
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Seção Vendedores -->
        <section class="page-section py-5" id="vendedores">
            <div class="container">
                <div class="row g-4" id="vendedoresContainer">
                    <?php if (empty($vendedores)): ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Nenhum vendedor encontrado</h4>
                            <p class="text-muted">Não há vendedores cadastrados no momento.</p>
                            
                            <?php if ($is_admin): ?>
                            <div class="mt-4">
                                <a href="vendedor.php?modal=novo_vendedor" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i> Cadastrar Primeiro Vendedor
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($vendedores as $vendedor): ?>
                            <div class="col-lg-4 col-md-6 vendedor-card">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="position-relative mb-4">
                                            <img src="<?php echo $vendedor['foto']; ?>" 
                                                 class="rounded-circle shadow" 
                                                 width="120" 
                                                 height="120"
                                                 alt="<?php echo htmlspecialchars($vendedor['nome']); ?>"
                                                 style="object-fit: cover;">
                                        </div>
                                        <h4 class="card-title mb-2"><?php echo htmlspecialchars($vendedor['nome']); ?></h4>
                                        <p class="text-muted mb-3"><?php echo htmlspecialchars($vendedor['cargo']); ?></p>
                                        <p class="card-text mb-4"><?php echo htmlspecialchars($vendedor['descricao']); ?></p>
                                        
                                        <?php if ($vendedor['telefone']): ?>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-phone me-2"></i><?php echo htmlspecialchars($vendedor['telefone']); ?>
                                        </p>
                                        <?php endif; ?>
                                        
                                        <?php if ($vendedor['link']): ?>
                                        <a href="<?php echo htmlspecialchars($vendedor['link']); ?>" 
                                           class="btn btn-success w-100" 
                                           target="_blank">
                                            <i class="fab fa-whatsapp me-2"></i> Falar com <?php echo explode(' ', $vendedor['nome'])[0]; ?>
                                        </a>
                                        <?php else: ?>
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fab fa-whatsapp me-2"></i> Contato não disponível
                                        </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($is_admin): ?>
                                        <div class="mt-3">
                                            <a href="vendedor.php?modal=editar_vendedor&id=<?php echo $vendedor['id']; ?>" 
                                               class="btn btn-warning btn-sm">Editar</a>
                                            <a href="vendedor.php?modal=excluir_vendedor&id=<?php echo $vendedor['id']; ?>" 
                                               class="btn btn-danger btn-sm">Excluir</a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php if (!$is_admin): ?>
        <div class="alert alert-info mt-5">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3 fs-4"></i>
                <div>
                    <h5 class="alert-heading mb-1">Horário de Atendimento</h5>
                    <p class="mb-0">Nossos vendedores estão disponíveis de Segunda a Sexta, das 7:30h às 11:30h e das 13:15h às 18:30h e no Sábado, das 8:00h às 11:30. Fora deste horário, você pode enviar uma mensagem pelo WhatsApp que retornaremos assim que possível.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Footer-->
        <?php include __DIR__ . '/includes/footer.php'; ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Modal para ações do admin -->
        <?php if (isset($_GET['modal'])): ?>
        <?php
            $modal_type = $_GET['modal'];
            $iframe_src = '';
            
            switch($modal_type) {
                case 'novo_vendedor':
                    $iframe_src = 'admin_php/crud_vendedor/novo_vendedor.php';
                    break;
                case 'editar_vendedor':
                    $iframe_src = 'admin_php/crud_vendedor/editar_vendedor.php?id=' . ($_GET['id'] ?? '');
                    break;
                case 'excluir_vendedor':
                    $iframe_src = 'admin_php/crud_vendedor/excluir_vendedor.php?id=' . ($_GET['id'] ?? '');
                    break;
                default:
                    $iframe_src = 'editar_iframe.php?tipo=' . htmlspecialchars($modal_type);
            }
        ?>
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
            <div class="modal-content" style="background: white; width: 80%; height: 80%; border-radius: 5px; position: relative;">
                <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                    <h5 class="m-0">
                        <?php 
                        $titulos = [
                            'novo_vendedor' => 'Novo Vendedor',
                            'editar_vendedor' => 'Editar Vendedor', 
                            'excluir_vendedor' => 'Excluir Vendedor'
                        ];
                        echo $titulos[$modal_type] ?? ucfirst(str_replace('_', ' ', $modal_type));
                        ?>
                    </h5>
                    <a href="vendedor.php" class="btn-close btn-close-white" style="text-decoration: none;" aria-label="Fechar"></a>
                </div>
                <iframe src="<?php echo $iframe_src; ?>" 
                        style="width: 100%; height: calc(100% - 50px); border: none;"></iframe>
            </div>
        </div>
        <?php endif; ?>
    </body>
</html>