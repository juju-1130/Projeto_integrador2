<div class="container mt-5">
    <table class="table table-bordered">
    <tbody>
        <tr><td>Tipos de telhado</td><td><a href="?modal=telhado" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Tipos de fase</td><td><a href="?modal=fase" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Concessionárias</td><td><a href="?modal=concessionaria" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Modelos de placas</td><td><a href="?modal=placa" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Inversores</td><td><a href="?modal=inversor" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Kit solar</td><td><a href="kit_solar.php" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Vendedores</td><td><a href="editar_vendedor.php" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
        <tr><td>Projetos</td><td><a href="cadastrar.php" class="btn btn-sm btn-outline-primary">Editar</a></td></tr>
    </tbody>
    </table>
</div>

<!-- Modal único -->
<?php if (isset($_GET['modal'])): ?>
<div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; width: 80%; height: 80%; border-radius: 5px; position: relative;">
        <iframe src="editar_iframe.php?tipo=<?php echo htmlspecialchars($_GET['modal']); ?>&iframe=1" 
        style="width: 100%; height: 100%; border: none;"></iframe>
    </div>
</div>
<?php endif; ?>
