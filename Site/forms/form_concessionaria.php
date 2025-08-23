<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessionária</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container p-0">
        <div class="custom-header d-flex justify-content-between align-items-center px-3 py-2">
            <h5 class="modal-title mb-0">Concessionária</h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Fechar" onclick="fecharIframe()"></button>
        </div>
        <div class="p-4">
            <form method="post" action="salvar.php?tipo=concessionaria" class="mb-4" id="formConcessionaria">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomeConcessionaria" class="form-label">Concessionária</label>
                        <input type="text" name="nomeConcessionaria" id="nomeConcessionaria" class="form-control">
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Adicionar Concessionária</button>
                </div>
            </form>

            <div class="mt-5">
                <h4>Concessionárias Cadastradas</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CEE</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="window.location.href='editar_inversor.php?id=1'">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="window.location.href='excluir_inversor.php?id=1'">Excluir</button>
                                </td>
                            </tr>
                            <tr>
                                <td>RGE</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="window.location.href='editar_inversor.php?id=2'">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="window.location.href='excluir_inversor.php?id=2'">Excluir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>