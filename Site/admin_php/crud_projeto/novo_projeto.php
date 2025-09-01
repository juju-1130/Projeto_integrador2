<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Projeto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Novo Projeto</h5>
        <a href="cadastrar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="salvar_projeto.php">
        <div class="row mb-3">
          <div class="col">
            <label for="titulo" class="form-label">Título do Projeto</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>
          
          <div class="col">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="placas" class="form-label">Quantidade de Placas</label>
            <input type="number" class="form-control" id="placas" name="placas" required>
          </div>
          <div class="col-md-4">
            <label for="potencia" class="form-label">Potência das Placas (W)</label>
              <select class="form-select" id="potencia" name="potencia" required>
                <option value="">Selecione a potência</option>
                <option value="570">570W</option>
                <option value="585">585W</option>
                <option value="610">610W</option>
                <option value="700">700W</option>
              </select>
          </div>        
          <div class="col md-4">
            <label for="inversor" class="form-label">Inversor</label>
              <select class="form-select" id="inversor" name="inversor" required>
                <option value="">Selecione o inversor</option>
                <option value="chint">Chint</option>
                <option value="growatt">Growatt</option>
                <option value="solis">Solis</option>
                <option value="saj">SAJ</option>
              </select>          
            </div>
        </div>
        <div class="row mb-3">
          <div class="col md-4">
            <label for="economia" class="form-label">Economia Mensal</label>
            <input type="text" class="form-control" id="economia" name="economia" required>
          </div>
          
          <div class="col md-4">
            <label for="conclusao" class="form-label">Data de Conclusão</label>
            <input type="text" class="form-control" id="conclusao" name="conclusao" required>
          </div>
          
          <div class="col md-4">
            <label for="tipo" class="form-label">Tipo de Projeto</label>
            <select class="form-select" id="tipo" name="tipo" required>
              <option value="">Selecione o tipo</option>
              <option value="Residencial">Residencial</option>
              <option value="Comercial">Comercial</option>
              <option value="Industrial">Industrial</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="imagem" class="form-label">Imagem do Projeto</label>
          <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="cadastrar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Projeto</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>