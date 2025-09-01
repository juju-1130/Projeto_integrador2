<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Projeto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php
$projetos = [
    1 => [
      'titulo' => 'Sistema solar de 6,27Kwp',
      'cidade' => 'Rolante',
      'placas' => '11',
      'potencia' => '570',
      'inversor' => 'Chint de 5Kw',
      'economia' => 'R$ 350/mês',
      'conclusao' => 'Jan/2023',
      'tipo' => 'Residencial'
    ],
    2 => [
      'titulo' => 'Sistema solar de 5,49Kwp',
      'cidade' => 'Rolante',
      'placas' => '9',
      'potencia' => '610',
      'inversor' => 'Chint de 5Kw',
      'economia' => 'R$ 350/mês',
      'conclusao' => 'Jan/2023',
      'tipo' => 'Residencial'
    ],
    3 => [
      'titulo' => 'Sistema solar de 5,13Kwp',
      'cidade' => 'Rolante',
      'placas' => '9',
      'potencia' => '570',
      'inversor' => 'Chint de 5Kw',
      'economia' => 'R$ 350/mês',
      'conclusao' => 'Jan/2023',
      'tipo' => 'Residencial'
    ]
];

$id = $_GET['id'] ?? '';
$projeto = $projetos[$id] ?? null;

if ($projeto): 
?>
<div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Editar Projeto</h5>
        <a href="cadastrar.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="atualizar_projeto.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="row mb-3">
          <div class="col">
            <label for="titulo" class="form-label">Título do Projeto</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $projeto['titulo']; ?>" required>
          </div>
          
          <div class="col">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $projeto['cidade']; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="placas" class="form-label">Quantidade de Placas</label>
            <input type="number" class="form-control" id="placas" name="placas" value="<?php echo $projeto['placas']; ?>" required>
          </div>
          <div class="col-md-4">
            <label for="potencia" class="form-label">Potência das Placas (W)</label>
              <select class="form-select" id="potencia" name="potencia" required>
                <option value="570" <?php echo $projeto['potencia'] == '570' ? 'selected' : ''; ?>>570W</option>
                <option value="585" <?php echo $projeto['potencia'] == '585' ? 'selected' : ''; ?>>585W</option>
                <option value="610" <?php echo $projeto['potencia'] == '610' ? 'selected' : ''; ?>>610W</option>
                <option value="700" <?php echo $projeto['potencia'] == '700' ? 'selected' : ''; ?>>700W</option>
              </select>          
            </div>
          <div class="col-md-4">
            <label for="inversor" class="form-label">Inversor</label>
              <select class="form-select" id="inversor" name="inversor" required>
                <option value="chint" <?php echo $projeto['inversor'] == 'chint' ? 'selected' : ''; ?>>Chint</option>
                <option value="growatt" <?php echo $projeto['inversor'] == 'growatt' ? 'selected' : ''; ?>>Growatt</option>
                <option value="solis" <?php echo $projeto['inversor'] == 'solis' ? 'selected' : ''; ?>>Solis</option>
                <option value="saj" <?php echo $projeto['inversor'] == 'saj' ? 'selected' : ''; ?>>SAJ</option>
              </select>           </div>
        </div>
        <div class="row mb-3">
          <div class="col md-4">
            <label for="economia" class="form-label">Economia Mensal</label>
            <input type="text" class="form-control" id="economia" name="economia" value="<?php echo $projeto['economia']; ?>" required>
          </div>
          
          <div class="col md-4">
            <label for="conclusao" class="form-label">Data de Conclusão</label>
            <input type="text" class="form-control" id="conclusao" name="conclusao" value="<?php echo $projeto['conclusao']; ?>" required>
          </div>
          
          <div class="col md-4">
            <label for="tipo" class="form-label">Tipo de Projeto</label>
            <select class="form-select" id="tipo" name="tipo" required>
              <option value="Residencial" <?php echo $projeto['tipo'] == 'Residencial' ? 'selected' : ''; ?>>Residencial</option>
              <option value="Comercial" <?php echo $projeto['tipo'] == 'Comercial' ? 'selected' : ''; ?>>Comercial</option>
              <option value="Industrial" <?php echo $projeto['tipo'] == 'Industrial' ? 'selected' : ''; ?>>Industrial</option>
            </select>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="imagem" class="form-label">Atualizar Imagem</label>
          <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="cadastrar.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
      </form>
    </div>
</div>
<?php else: ?>
<div class="container p-0">
    <div class="alert alert-danger">Projeto não encontrado.</div>
</div>
<?php endif; ?>
</body>
</html>