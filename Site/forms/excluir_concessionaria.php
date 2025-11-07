<?php
include_once '../conexao.php';

$concessionaria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($concessionaria_id > 0){
    $sql = "DELETE FROM Concessionaria WHERE concessionaria_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("i", $concessionaria_id);
        
        if($stmt->execute()){
            header("Location: form_concessionaria.php");
            exit();
        } else{
            die("Erro ao excluir concessionária: " . $conn->error);
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