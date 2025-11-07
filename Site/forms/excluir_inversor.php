<?php
include_once '../conexao.php';

$inversor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($inversor_id > 0){
    $sql = "DELETE FROM Inversor WHERE inversor_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("i", $inversor_id);
        
        if($stmt->execute()){
            header("Location: form_inversor.php");
            exit();
        } else{
            die("Erro ao excluir inversor: " . $conn->error);
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