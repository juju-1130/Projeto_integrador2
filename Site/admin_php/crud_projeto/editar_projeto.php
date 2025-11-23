<?php
require '../../conexao.php';
include __DIR__ . '/../../includes/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $cidade = $_POST['cidade'];
    $quantidade_placas = $_POST['quantidade_placas'];
    $placa_id = $_POST['placa_id'];
    $inversor_id = $_POST['inversor_id'];
    $economia = $_POST['economia'];
    $conclusao = $_POST['conclusao'];
    $tipo = $_POST['tipo'];
    $caracteristica = $_POST['caracteristica'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $upload_dir = '../../uploads/projetos/';
        
        // Criar diretório se não existir
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $imagem_path = $upload_dir . $imagem_nome;
        
        if (move_uploaded_file($imagem_temp, $imagem_path)) {
            $sql = "UPDATE projeto SET titulo=?, cidade=?, quantidade_placas=?, placa_id=?, inversor_id=?, economia=?, conclusao=?, tipo=?, caracteristica=?, imagem=? WHERE projeto_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiiidssssi", $titulo, $cidade, $quantidade_placas, $placa_id, $inversor_id, $economia, $conclusao, $tipo, $caracteristica, $imagem_nome, $id);
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    Erro ao fazer upload da imagem.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    } else {
        $sql = "UPDATE projeto SET titulo=?, cidade=?, quantidade_placas=?, placa_id=?, inversor_id=?, economia=?, conclusao=?, tipo=?, caracteristica=? WHERE projeto_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiidsssi", $titulo, $cidade, $quantidade_placas, $placa_id, $inversor_id, $economia, $conclusao, $tipo, $caracteristica, $id);
    }

    if (isset($stmt) && $stmt->execute()) {
        echo '<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                Projeto atualizado com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        
        // Recarregar os dados atualizados
        $sql = "SELECT * FROM projeto WHERE projeto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $projeto = $stmt->get_result()->fetch_assoc();
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                Erro ao atualizar projeto: ' . (isset($stmt) ? $stmt->error : 'Erro na preparação da query') . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM projeto WHERE projeto_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$projeto = $result->fetch_assoc();

if (!$projeto) {
    die('<div class="alert alert-danger m-3">Projeto não encontrado!</div>');
}

// Buscar placas e inversores para os selects
$placas = $conn->query("SELECT placa_id, marca_placa, potencia_placa FROM Placa");
$inversores = $conn->query("SELECT inversor_id, marca_inversor, potencia_inversor FROM Inversor");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>    

    <body>
        <div class="container p-0">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                <h5 class="m-0">Editar Projeto</h5>
                <a href="../../projetos.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
            </div>
            <div class="p-3">
                <form method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <input type="hidden" name="id" value="<?= $projeto['projeto_id'] ?>">

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Título:</label>
                            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($projeto['titulo']) ?>" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Cidade:</label>
                            <?php echo gerarCampoCidade('cidade', $projeto['cidade']); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantidade de Placas:</label>
                            <input type="number" name="quantidade_placas" class="form-control" min="0" value="<?= $projeto['quantidade_placas'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Placa:</label>
                            <select name="placa_id" class="form-select" required>
                                <option value="">-- selecione --</option>
                                <?php 
                                $placas->data_seek(0); // Reset do ponteiro do resultado
                                while ($p = $placas->fetch_assoc()): ?>
                                    <option value="<?= $p['placa_id'] ?>" <?= $p['placa_id'] == $projeto['placa_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['marca_placa']) ?> (<?= $p['potencia_placa'] ?>W)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Inversor:</label>
                            <select name="inversor_id" class="form-select" required>
                                <option value="">-- selecione --</option>
                                <?php 
                                $inversores->data_seek(0); // Reset do ponteiro do resultado
                                while ($i = $inversores->fetch_assoc()): ?>
                                    <option value="<?= $i['inversor_id'] ?>" <?= $i['inversor_id'] == $projeto['inversor_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($i['marca_inversor']) ?> (<?= $i['potencia_inversor'] ?> kW)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Economia Mensal (R$):</label>
                            <input type="number" step="0.01" name="economia" class="form-control" min="0" value="<?= $projeto['economia'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Data de Conclusão:</label>
                            <input type="date" name="conclusao" class="form-control" value="<?= $projeto['conclusao'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo:</label>
                            <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($projeto['tipo']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Característica:</label>
                        <textarea name="caracteristica" class="form-control" rows="4"><?= htmlspecialchars($projeto['caracteristica']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagem Atual:</label><br>
                        <?php if ($projeto['imagem']): ?>
                            <img src="../uploads/projetos/<?= $projeto['imagem'] ?>" width="150" class="img-thumbnail mb-2">
                            <br>
                            <small class="text-muted"><?= $projeto['imagem'] ?></small>
                        <?php else: ?>
                            <span class="text-muted">Nenhuma imagem cadastrada</span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nova Imagem (opcional):</label>
                        <input type="file" name="imagem" accept="image/*" class="form-control" onchange="validarImagem(this)">
                        <small class="text-muted">Tamanho máximo: 10MB. Formatos: JPG, PNG, GIF, WEBP</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../projetos.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar Projeto</button>
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
        </script>
    </body>
</html>
