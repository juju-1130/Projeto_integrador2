<?php
include_once '../conexao.php';

$telhado_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($telhado_id > 0){

    $sql_select = "SELECT foto_telhado FROM Telhado WHERE telhado_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $telhado_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $telhado = $result->fetch_assoc();
    $stmt_select->close();
    
    if($telhado['foto_telhado']){
        $imagem_path = '../uploads/telhados/' . $telhado['foto_telhado'];
        if(file_exists($imagem_path)){
            unlink($imagem_path);
        }
    }
    
    $sql = "DELETE FROM Telhado WHERE telhado_id = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt){
        $stmt->bind_param("i", $telhado_id);
        
        if($stmt->execute()){
            header("Location: form_telhado.php");
            exit();
        } else{
            die("Erro ao excluir telhado: " . $conn->error);
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