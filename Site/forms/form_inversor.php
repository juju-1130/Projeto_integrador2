<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inversores</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container p-0">
        <div class="custom-header d-flex justify-content-between align-items-center px-3 py-2">
            <h5 class="modal-title mb-0">Inversores</h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Fechar" onclick="fecharIframe()"></button>
        </div>
        <div class="p-4">
            <form method="post" action="salvar.php?tipo=inversor" class="mb-4" id="formInversor">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="marcaInversor" class="form-label">Marca:</label>
                        <input type="text" name="marcaInversor" id="marcaInversor" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="potenciaInversor" class="form-label">Potência (KW):</label>
                        <input type="number" name="potenciaInversor" id="potenciaInversor" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="valorInversor" class="form-label">Valor (R$):</label>
                        <input type="number" name="valorInversor" id="valorInversor" class="form-control" required>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Adicionar Inversor</button>
                </div>
            </form>

            <div class="mt-5">
                <h4>Inversores Cadastrados</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Potência (KW)</th>
                                <th>Valor (R$)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Chint</td>
                                <td>5.0</td>
                                <td>1.100,00</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="window.location.href='editar_inversor.php?id=1'">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="window.location.href='excluir_inversor.php?id=1'">Excluir</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Growatt</td>
                                <td>3.0</td>
                                <td>900,00</td>
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