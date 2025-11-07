<?php
include_once '../conexao.php';

if($_POST && isset($_POST['tipo'])){
    $tipo = $_POST['tipo'];
    $imagem_nome = '';
    
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        $upload_dir = '../uploads/telhados/';
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }
        
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $imagem_path = $upload_dir . $imagem_nome;
        
        if(move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)){
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Erro ao fazer upload da imagem.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        }
    }
    
    $sql = "INSERT INTO Telhado (tipo_telhado, foto_telhado) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tipo, $imagem_nome);
    
    if($stmt->execute()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Telhado adicionado com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao adicionar telhado: " . $conn->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM Telhado ORDER BY telhado_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/../head.php'; ?>
  <body>
    <div class="container p-0">
      <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Tipos de Telhado</h5>
        <a href="../admin_php/editar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
      </div>

      <div class="p-3">
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col">
              <label for="tipo" class="form-label">Tipo do Telhado</label>
              <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="col">
              <label for="imagem" class="form-label">Imagem do Telhado</label>
              <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
            </div>
          </div>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="../admin_php/editar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Adicionar Telhado</button>
          </div>
        </form>

        <hr>

        <h5 class="mt-3">Telhados Cadastrados</h5>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Tipo</th>
              <th>Imagem</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $imagem_path = $row['foto_telhado'] ? "../uploads/telhados/" . $row['foto_telhado'] : "../uploads/placeholder.jpg";
                    echo "<tr>";
                    echo "<td>{$row['tipo_telhado']}</td>";
                    echo "<td><img src='{$imagem_path}' width='50' alt='{$row['tipo_telhado']}' style='object-fit: cover;'></td>";
                    echo "<td>";
                    echo "<a href='../forms/editar_telhado.php?id={$row['telhado_id']}' class='btn btn-warning btn-sm'>Editar</a> ";
                    echo "<a href='../forms/excluir_telhado.php?id={$row['telhado_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>Nenhum telhado cadastrado.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<?php
$conn->close();
?>