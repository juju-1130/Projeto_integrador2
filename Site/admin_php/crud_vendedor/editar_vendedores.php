<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Vendedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php
$vendedores = [
    1 => [
      'nome' => 'Jonathan Kirsch',
      'cargo' => 'Especialista em Energia Solar e CEO',
      'descricao' => 'Atendimento personalizado para encontrar a melhor solução em energia solar para sua necessidade.',
      'whatsapp' => '5551999999999',
      'mensagem' => 'Olá Jonathan, gostaria de informações sobre energia solar'
    ],
    2 => [
      'nome' => 'Dhonavan Dias',
      'cargo' => 'Consultor e Especialista em Energia Solar',
      'descricao' => 'Especialista em projetos personalizados para maximizar sua economia com energia solar.',
      'whatsapp' => '5551999999998',
      'mensagem' => 'Olá Dhonavan, gostaria de informações sobre energia solar'
    ],
    3 => [
      'nome' => 'MK Energia Solar',
      'cargo' => 'Especialista em Garantir Maior Comodidade aos Clientes',
      'descricao' => 'Empresa Especialista em Energia Solar',
      'whatsapp' => '5551999999997',
      'mensagem' => 'Olá MK, gostaria de informações sobre energia solar'
    ]
];

$id = $_GET['id'] ?? '';
$vendedor = $vendedores[$id] ?? null;

if ($vendedor): 
?>
<div class="container p-0">
    <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
        <h5 class="m-0">Editar Vendedor</h5>
        <a href="editar_vendedor.php" target="_parent" class="btn-close btn-close-white" aria-label="Fechar"></a>
    </div>

    <div class="p-3">
      <form method="POST" action="atualizar_vendedor.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="row mb-3">
          <div class="col">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $vendedor['nome']; ?>" required>
          </div>
          <div class="col">
            <label for="cargo" class="form-label">Cargo/Especialidade</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo $vendedor['cargo']; ?>" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição</label>
          <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo $vendedor['descricao']; ?></textarea>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="whatsapp" class="form-label">Número do WhatsApp</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $vendedor['whatsapp']; ?>" required>
            </div>
          </div>
          <div class="col-md-6">
            <label for="mensagem" class="form-label">Mensagem Padrão</label>
            <input type="text" class="form-control" id="mensagem" name="mensagem" value="<?php echo $vendedor['mensagem']; ?>" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="foto" class="form-label">Atualizar Foto</label>
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="editar_vendedor.php" target="_parent" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
      </form>
    </div>
</div>
<?php else: ?>
<div class="container p-0">
    <div class="alert alert-danger">Vendedor não encontrado.</div>
</div>
<?php endif; ?>
</body>
</html>