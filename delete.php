
<?php
// Processa ambiente deletar após confirmação do form

if(isset($_POST["ClienteID"]) && !empty($_POST["ClienteID"])){
    // Inclui página config
    require_once "config.php";
    
    // Prepara ambiente para deletar e atribui ambiente estático
    $sql = "DELETE FROM clientes WHERE ClienteID = ?";
   
    if($stmt = mysqli_prepare($link, $sql)){
        // variáveis definidas para deletar cliente
        mysqli_stmt_bind_param($stmt, "s", $param_clienteid);
        
        // Define parâmetros
        $param_clienteid = trim($_POST["ClienteID"]);
        
        // executa parâmetros estáticos
        if(mysqli_stmt_execute($stmt)){
            // Grava e carrega página de início
            header("location: index.php");
            exit();
        } else{
            echo "Algo deu errado tente por favor mais tarde.";
        }
    }
     
    // Fecha conexão estática
    mysqli_stmt_close($stmt);
    
    // Fecha conexão
    mysqli_close($link);
} else{
   
    // Checa existência de parâmetros
    if(empty(trim($_GET["ClienteID"]))){
        //Caso não houver informa usuário com notificação de erros     
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deletar Cliente ?</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Deletar Cliente ?</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="ClienteID" value="<?php echo trim($_GET["ClienteID"]); ?>"/>
                            <p>Deseja realmente excluir este cliente ?</p>
                            <p>
                                <input type="submit" value="Sim" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">Não</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
