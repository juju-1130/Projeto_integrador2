<!DOCTYPE html>
<html lang="pt-BR">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    

    <?php
    require '../../conexao.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';
        
        if (!empty($id)) {
            $sql_select = "SELECT titulo FROM projeto WHERE projeto_id = ?";
            $stmt_select = $conn->prepare($sql_select);
            $stmt_select->bind_param("i", $id);
            $stmt_select->execute();
            $projeto = $stmt_select->get_result()->fetch_assoc();
            $stmt_select->close();
            
            $sql_delete = "DELETE FROM projeto WHERE projeto_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            
            if ($stmt_delete->execute()) {
                echo '<script>
                        alert("Projeto excluído com sucesso!");
                        window.parent.location.href = "../../projetos.php";
                      </script>';
                exit;
            } else {
                echo '<script>
                        alert("Erro ao excluir projeto: ' . $conn->error . '");
                        window.parent.location.href = "../../projetos.php";
                      </script>';
                exit;
            }
        }
    }

    $id = $_GET['id'] ?? '';
    $projeto = null;
    
    if (!empty($id)) {
        $sql = "SELECT p.*, 
                       pl.marca_placa, pl.potencia_placa,
                       i.marca_inversor, i.potencia_inversor
                FROM projeto p
                LEFT JOIN Placa pl ON p.placa_id = pl.placa_id
                LEFT JOIN Inversor i ON p.inversor_id = i.inversor_id
                WHERE p.projeto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $projeto = $stmt->get_result()->fetch_assoc();
    }
    ?>

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Excluir Projeto</h5>
                <a href="../../projetos.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>

            <?php if ($projeto): ?>
            <div class="p-3">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Tem certeza que deseja excluir este projeto?</h5>
                    <p class="mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">Detalhes do Projeto</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary"><?php echo htmlspecialchars($projeto['titulo']); ?></h5>
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <?php echo htmlspecialchars($projeto['cidade']); ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-solar-panel text-muted me-2"></i>
                                    <?php echo $projeto['quantidade_placas']; ?> módulos de <?php echo $projeto['potencia_placa']; ?>W
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-bolt text-muted me-2"></i>
                                    Inversor <?php echo htmlspecialchars($projeto['marca_inversor']); ?> de <?php echo $projeto['potencia_inversor']; ?>kW
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-battery-three-quarters text-muted me-2"></i>
                                    Economia: R$ <?php echo number_format($projeto['economia'], 2, ',', '.'); ?>/mês
                                </p>
                                <p class="mb-0">
                                    <i class="far fa-calendar-alt text-muted me-2"></i>
                                    Concluído: <?php echo date('d/m/Y', strtotime($projeto['conclusao'])); ?>
                                </p>
                            </div>
                        </div>
                        
                        <?php if ($projeto['caracteristica']): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Características:</label>
                                <p class="text-muted"><?php echo htmlspecialchars($projeto['caracteristica']); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($projeto['imagem']): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Imagem do Projeto:</label><br>
                                <img src="../uploads/projetos/<?php echo $projeto['imagem']; ?>" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;" 
                                     alt="<?php echo htmlspecialchars($projeto['titulo']); ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <form method="POST" action="excluir_projeto.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../projetos.php" target="_parent" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Excluir Projeto
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="p-3">
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-circle me-2"></i>Projeto não encontrado</h5>
                    <p class="mb-0">O projeto que você está tentando excluir não existe ou já foi removido.</p>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="../../projetos.php" target="_parent" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar para Projetos
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