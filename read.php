<?php
// Checa váriaveis que serão utilizadas em processos futuros
if(isset($_GET["ClienteID"]) && !empty(trim($_GET["ClienteID"]))){
    // Inclui página config
    require_once "config.php";
    
    // Prepara query para receber parâmetros estáticos
    $sql = "SELECT * FROM clientes WHERE ClienteID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Recebe parâmetros estáticos
        mysqli_stmt_bind_param($stmt, "i", $param_clienteid);
        
        // Define parâmetros
        $param_clienteid = trim($_GET["ClienteID"]);
        
        // Executa query
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /*Verifica se o número de linhas é maior que zero se for entrará para definição de variáveis*/
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Define valores as variáveis
                $name = $row["Nome"];
                $telefone = $row["Telefone"];
                $cpf = $row["Cpf"];
                $placacarro = $row["PlacaCarro"];
            } else{
                // Informa que a url não contém valores para definição de leitura
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Algo deu errado, por favor tente novamente mais tarde.";
        }
    }
     
    // Fecha conexão estática
    mysqli_stmt_close($stmt);
    
    // Fecha conexão
    mysqli_close($link);
} else{
    // Retorna página principal caso não há variáveis para lançamento da query
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gravado</title>
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
                    <h1 class="mt-5 mb-3">Dados do Cliente</h1>
                    <div class="form-group">
                        <label>Nome</label>
                        <p><b><?php echo $row["Nome"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <p><b><?php echo $row["Telefone"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Cpf</label>
                        <p><b><?php echo $row["Cpf"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Placa do Carro</label>
                        <p><b><?php echo $row["PlacaCarro"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
