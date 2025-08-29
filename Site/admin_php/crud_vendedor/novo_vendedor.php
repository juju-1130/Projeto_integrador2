<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Vendedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Novo Vendedor</h5>
        <a href="../admin_php/editar_vendedor.php" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="salvar_vendedor.php">
        <div class="row mb-3">
          <div class="col">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="col">
            <label for="cargo" class="form-label">Cargo/Especialidade</label>
            <input type="text" class="form-control" id="cargo" name="cargo" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição</label>
          <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="whatsapp" class="form-label">Número do WhatsApp</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="5511999999999" required>
            </div>
          </div>
          <div class="col-md-6">
            <label for="mensagem" class="form-label">Mensagem Padrão</label>
            <input type="text" class="form-control" id="mensagem" name="mensagem" value="Olá, gostaria de informações sobre energia solar" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="foto" class="form-label">Foto do Vendedor</label>
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="../admin_php/editar_vendedor.php" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Vendedor</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>