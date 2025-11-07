<?php
include_once '../conexao.php';

$placa_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($placa_id > 0){
    $sql = "DELETE FROM Placa WHERE placa_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("i", $placa_id);
        
        if($stmt->execute()){
            header("Location: form_placa.php");
            exit();
        } else{
            die("Erro ao excluir placa: " . $conn->error);
        }
        $stmt->close();
    } else {
        die("Erro na preparação da query: " . $conn->error);
    }
} else {
    die("ID não especificado.");
}

$conn->close();
?>