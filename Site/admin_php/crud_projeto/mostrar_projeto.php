<?php
require 'conexao.php';

$sql = "SELECT projeto_id, titulo, cidade, quantidade_placas, economia, conclusao FROM projeto";
$result = $conn->query($sql);
?>

<h2>Lista de Projetos</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Imagem</th>
        <th>Título</th>
        <th>Cidade</th>
        <th>Placas</th>
        <th>Economia</th>
        <th>Conclusão</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><img src="ver_imagem.php?id=<?= $row['projeto_id'] ?>" width="120"></td>
        <td><?= $row['titulo'] ?></td>
        <td><?= $row['cidade'] ?></td>
        <td><?= $row['quantidade_placas'] ?></td>
        <td><?= $row['economia'] ?></td>
        <td><?= $row['conclusao'] ?></td>
        <td>
            <a href="../crud_projeto/editar_projeto.php?id=<?= $row['projeto_id'] ?>">Editar</a> |
            <a href="deletar_projeto.php?id=<?= $row['projeto_id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
