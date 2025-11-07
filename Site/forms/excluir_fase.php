<?php
include_once '../conexao.php';

$fase_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($fase_id > 0){
    $sql = "DELETE FROM Fase WHERE fase_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("i", $fase_id);
        
        if($stmt->execute()){
            header("Location: form_fase.php");
            exit();
        } else{
            die("Erro ao excluir fase: " . $conn->error);
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