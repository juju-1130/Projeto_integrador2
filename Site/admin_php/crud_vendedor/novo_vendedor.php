<!DOCTYPE html>
<html lang="pt-br">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    

    <?php
    require '../../conexao.php';

    if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
        echo '<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                Vendedor salvo com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    if (isset($_GET['erro'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                Erro: ' . htmlspecialchars($_GET['erro']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    ?>

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Novo Vendedor</h5>
                <a href="../../vendedor.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>
            <div class="p-3">
                <form method="post" action="salvar_vendedor.php" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome do Vendedor:</label>
                            <input type="text" name="nome_vendedor" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cargo:</label>
                            <input type="text" name="cargo" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição:</label>
                        <textarea name="descricao" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Telefone:</label>
                            <input type="text" name="telefone_vendedor" class="form-control" placeholder="(11) 99999-9999">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link do WhatsApp:</label>
                            <input type="url" name="link_vendedor" class="form-control" placeholder="https://wa.me/5511999999999">
                            <small class="text-muted">Link completo do WhatsApp (ex: https://wa.me/5511999999999)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto:</label>
                        <input type="file" name="foto_vendedor" accept="image/*" class="form-control" onchange="validarImagem(this)">
                        <small class="text-muted">Tamanho máximo: 5MB. Formatos: JPG, PNG, GIF. Recomendado: 120x120px</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../vendedor.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar Vendedor</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
        function validarImagem(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 5 * 1024 * 1024; 
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                
                if (file.size > maxSize) {
                    alert('A imagem é muito grande. Por favor, selecione uma imagem menor que 5MB.');
                    input.value = ''; 
                    return false;
                }
                
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de arquivo não permitido. Use apenas JPG, PNG ou GIF.');
                    input.value = ''; 
                    return false;
                }
            }
            return true;
        }

        function validarFormulario() {
            const nome = document.querySelector('input[name="nome_vendedor"]').value.trim();
            const cargo = document.querySelector('input[name="cargo"]').value.trim();
            const descricao = document.querySelector('textarea[name="descricao"]').value.trim();
            
            if (!nome) {
                alert('Por favor, preencha o nome do vendedor.');
                return false;
            }
            
            if (!cargo) {
                alert('Por favor, preencha o cargo do vendedor.');
                return false;
            }
            
            if (!descricao) {
                alert('Por favor, preencha a descrição do vendedor.');
                return false;
            }
            
            const imagemInput = document.querySelector('input[name="foto_vendedor"]');
            if (imagemInput.files.length > 0) {
                return validarImagem(imagemInput);
            }
            
            return true;
        }
        </script>
    </body>
</html>