<!DOCTYPE html>
<html lang="pt-br">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    

    <?php
    require '../../conexao.php';
    include __DIR__ . '/../../includes/funcoes.php';

    // Mensagens de feedback
    if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
        echo '<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                Projeto salvo com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    if (isset($_GET['erro'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Erro: ' . htmlspecialchars($_GET['erro']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    $placas = $conn->query("SELECT placa_id, marca_placa, potencia_placa FROM Placa");
    $inversores = $conn->query("SELECT inversor_id, marca_inversor, potencia_inversor FROM Inversor");
    ?>

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Novo Projeto</h5>
                <a href="../../projetos.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>
            <div class="p-3">
                <form method="post" action="salvar_projeto.php" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Título:</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Cidade:</label>
                            <?php echo gerarCampoCidade(); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantidade de Placas:</label>
                            <input type="number" name="quantidade_placas" class="form-control" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Placa:</label>
                            <select name="placa_id" class="form-select" required>
                                <option value="">-- selecione --</option>
                                <?php while ($p = $placas->fetch_assoc()): ?>
                                    <option value="<?= $p['placa_id'] ?>">
                                        <?= htmlspecialchars($p['marca_placa']) ?> (<?= $p['potencia_placa'] ?>W)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Inversor:</label>
                            <select name="inversor_id" class="form-select" required>
                                <option value="">-- selecione --</option>
                                <?php while ($i = $inversores->fetch_assoc()): ?>
                                    <option value="<?= $i['inversor_id'] ?>">
                                        <?= htmlspecialchars($i['marca_inversor']) ?> (<?= $i['potencia_inversor'] ?> kW)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Economia Mensal (R$):</label>
                            <input type="number" step="0.01" name="economia" class="form-control" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Data de Conclusão:</label>
                            <input type="date" name="conclusao" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo:</label>
                            <input type="text" name="tipo" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Característica:</label>
                        <textarea name="caracteristica" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagem:</label>
                        <input type="file" name="imagem" accept="image/*" class="form-control" onchange="validarImagem(this)">
                        <small class="text-muted">Tamanho máximo: 10MB. Formatos: JPG, PNG, GIF, WEBP</small>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../projetos.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Projeto
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php carregarAPICidades(); ?>

        <script>
        function validarImagem(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 10 * 1024 * 1024; // 10MB
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                
                if (file.size > maxSize) {
                    alert('A imagem é muito grande. Por favor, selecione uma imagem menor que 10MB.');
                    input.value = ''; 
                    return false;
                }
                
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de arquivo não permitido. Use apenas JPG, PNG, GIF ou WEBP.');
                    input.value = ''; 
                    return false;
                }
            }
            return true;
        }

        function validarFormulario() {
            const titulo = document.querySelector('input[name="titulo"]').value.trim();
            const placa = document.querySelector('select[name="placa_id"]').value;
            const inversor = document.querySelector('select[name="inversor_id"]').value;
            
            if (!titulo) {
                alert('Por favor, preencha o título do projeto.');
                return false;
            }
            
            if (!placa) {
                alert('Por favor, selecione uma placa.');
                return false;
            }
            
            if (!inversor) {
                alert('Por favor, selecione um inversor.');
                return false;
            }
            
            const imagemInput = document.querySelector('input[name="imagem"]');
            if (imagemInput.files.length > 0) {
                return validarImagem(imagemInput);
            }
            
            return true;
        }

        // Fechar automaticamente o alerta após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alertas = document.querySelectorAll('.alert');
            alertas.forEach(alerta => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alerta);
                    bsAlert.close();
                }, 5000);
            });
        });
        </script>
    </body>
</html>