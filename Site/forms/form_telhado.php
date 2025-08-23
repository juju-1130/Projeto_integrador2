<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telhado</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container p-0">
        <div class="custom-header d-flex justify-content-between align-items-center px-3 py-2">
            <h5 class="modal-title mb-0">Telhado</h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Fechar" onclick="fecharIframe()"></button>
        </div>
        <div class="p-4">
            <form method="post" action="salvar.php?tipo=telhado" class="mb-4" id="formTelhado">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipoTelhado" class="form-label">Tipo do Telhado:</label>
                        <input type="text" name="tipoTelhado" id="tipoTelhado" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="imagemTelhado" class="form-label">Imagem do Telhado:</label>
                        <input type="file" name="imagemTelhado" id="imagemTelhado" class="form-control">
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Adicionar Telhado</button>
                </div>
            </form>

            <div class="mt-5">
                <h4>Telhados Cadastrados</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Imagem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Telhado Cerâmico</td>
                                <td><img src="placeholder.jpg" width="50" alt="Telhado Cerâmico"></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="window.location.href='editar_inversor.php?id=1'">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="window.location.href='excluir_inversor.php?id=1'">Excluir</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Telhado Metálico</td>
                                <td><img src="placeholder.jpg" width="50" alt="Telhado Metálico"></td>
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