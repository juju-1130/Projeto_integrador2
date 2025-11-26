<!DOCTYPE html>
<html lang="pt-BR">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    

    <?php
    require '../../conexao.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';
        
        if (!empty($id)) {
            $sql_select = "SELECT nome_vendedor FROM Vendedor WHERE vendedor_id = ?";
            $stmt_select = $conn->prepare($sql_select);
            $stmt_select->bind_param("i", $id);
            $stmt_select->execute();
            $vendedor = $stmt_select->get_result()->fetch_assoc();
            $stmt_select->close();
            
            $sql_delete = "DELETE FROM Vendedor WHERE vendedor_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            
            if ($stmt_delete->execute()) {
                echo '<script>
                        alert("Vendedor excluído com sucesso!");
                        window.parent.location.href = "../../vendedor.php";
                      </script>';
                exit;
            } else {
                echo '<script>
                        alert("Erro ao excluir vendedor: ' . $conn->error . '");
                        window.parent.location.href = "../../vendedor.php";
                      </script>';
                exit;
            }
        }
    }

    $id = $_GET['id'] ?? '';
    $vendedor = null;
    
    if (!empty($id)) {
        $sql = "SELECT * FROM Vendedor WHERE vendedor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $vendedor = $stmt->get_result()->fetch_assoc();
    }
    ?>

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Excluir Vendedor</h5>
                <a href="../../vendedor.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>

            <?php if ($vendedor): ?>
            <div class="p-3">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Tem certeza que deseja excluir este vendedor?</h5>
                    <p class="mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">Detalhes do Vendedor</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary"><?php echo htmlspecialchars($vendedor['nome_vendedor']); ?></h5>
                                <p class="mb-2">
                                    <i class="fas fa-briefcase text-muted me-2"></i>
                                    <?php echo htmlspecialchars($vendedor['cargo']); ?>
                                </p>
                                <?php if ($vendedor['telefone_vendedor']): ?>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    <?php echo htmlspecialchars($vendedor['telefone_vendedor']); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?php if ($vendedor['link_vendedor']): ?>
                                <p class="mb-2">
                                    <i class="fab fa-whatsapp text-muted me-2"></i>
                                    <a href="<?php echo htmlspecialchars($vendedor['link_vendedor']); ?>" target="_blank">
                                        Link WhatsApp
                                    </a>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if ($vendedor['descricao']): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Descrição:</label>
                                <p class="text-muted"><?php echo htmlspecialchars($vendedor['descricao']); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($vendedor['foto_vendedor']): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Foto do Vendedor:</label><br>
                                <img src="../uploads/vendedores/<?php echo $vendedor['foto_vendedor']; ?>" 
                                     class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;" 
                                     alt="<?php echo htmlspecialchars($vendedor['nome_vendedor']); ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <form method="POST" action="excluir_vendedor.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../vendedor.php" target="_parent" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Excluir Vendedor
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="p-3">
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-circle me-2"></i>Vendedor não encontrado</h5>
                    <p class="mb-0">O vendedor que você está tentando excluir não existe ou já foi removido.</p>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="../../vendedores.php" target="_parent" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar para Vendedores
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Excluindo...';
                });
            }
        });
        </script>
    </body>
</html>