<?php
// Inclui página config
require_once "config.php";
 
// Define variáveis para receber vazio
$nome = $telefone = $cpf = $placacarro = "";
$nome_err = $telefone_err = $cpf_err = $placacarro_err = "";
 
// Verifica se variáveis não estão vazias após o form 
if(isset($_POST["ClienteID"]) && !empty($_POST["ClienteID"])){
    // Recebe valores
    $clienteid = $_POST["ClienteID"];
    
    // Valida nome
    $input_nome = trim($_POST["Nome"]);
    if(empty($input_nome)){
        $nome_err = "Entre com um nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Entre com um nome válido";
    } else{
        $nome = $input_nome;
    }
    
    // Validando telefone
    $input_telefone = trim($_POST["Telefone"]);
    if(empty($input_telefone)){
        $telefone_err = "Por favor entre com um Telefone válido.";     
    } else{
        $telefone = $input_telefone;
    }
    
    // Validando cpf
    $input_cpf = trim($_POST["Cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Entre com o cpf";     
    } elseif(!ctype_digit($input_cpf)){
        $cpf_err = "Entre com um cpf válido.";
    } else{
        $cpf= $input_cpf;
    }
    
   // Validando Placa do carro
   $input_placacarro = trim($_POST["PlacaCarro"]);
   if(empty($input_placacarro)){
       $placacarro_err = "Entre com a Placa do Carro";     
   } elseif(!ctype_digit($input_placacarro)){
       $placacarro_err = "Entre com uma placa válida";
   } else{
       $placacarro= $input_placacarro;
   }
   

    // Checa erros na inserção do banco de dados caso haja fields vazias
    if(empty($nome_err) && empty($telefone_err) && empty($cpf_err) && empty($placacarro_err)){
        // Prepara para inserção dos dados editados
        $sql = "UPDATE clientes SET Nome=?, Telefone=?, Cpf=?, PlacaCarro=? WHERE ClienteID=?";
    
        if($stmt = mysqli_prepare($link, $sql)){
            // Prepara linha (query) para receber parâmetros
            mysqli_stmt_bind_param($stmt, "sssss", $param_nome, $param_telefone, $param_cpf, $param_placacarro, $param_clienteid);
            
            // Define Parâmetros
            $param_nome = $nome;
            $param_telefone = $telefone;
            $param_cpf = $cpf;
            $param_placacarro = $placacarro;
            $param_clienteid = $clienteid;
            
            echo $param_nome; 
            echo $param_telefone; 
            echo $param_cpf; 
            echo $param_clienteid; 
            echo "Imprime as variaveis"; 
            echo $$nome; 
            echo $telefone; 
            echo $placacarro; 
            echo $clienteid; 

            // Executa query com variáveis estáticas
            if(mysqli_stmt_execute($stmt)){
                // Caso inserção ok, retorna página principal  com os dados alterados
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Fecha conexão estática
        mysqli_stmt_close($stmt);
    }
    
    // Fecha conexão
    mysqli_close($link);
} else{
    // checa existência de valores nas funções para processos futuros
    if(isset($_GET["ClienteID"]) && !empty(trim($_GET["ClienteID"]))){
        // Obtém URL
        $clienteid =  trim($_GET["ClienteID"]);
        
        // Prepara query estática
        $sql = "SELECT * FROM clientes WHERE ClienteID = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Função enviando valores estáticos para serem executadas
            mysqli_stmt_bind_param($stmt, "i", $param_clienteid);
            
            // Define parâmetros
            $param_clienteid = $clienteid;
            
            //Prepara query com valores estáticos
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /*Se o resultado da execução for maior que zero as variáveis irão receber valores */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    //Variáveis recebendo valores
                    $nome = $row["Nome"];
                    $telefone = $row["Telefone"];
                    $cpf = $row["Cpf"];
                    $placacarro = $row["PlacaCarro"];
                } else{
                    // Caso não for igual a zero informará usuário com mensagem de erro
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Fecha query com valores estáticos
        mysqli_stmt_close($stmt);
        
        // Fecha conexão
        mysqli_close($link);
    }  else{
        // Redireciona para página de erros
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php       echo $placacarro;  ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Alterar Dados do Cliente</h2>
           
                    <p>Aqui você pode alterar dados cadastrais do cliente.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="Nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <textarea name="Telefone" class="form-control <?php echo (!empty($telefone_err)) ? 'is-invalid' : ''; ?>"><?php echo $telefone; ?></textarea>
                            <span class="invalid-feedback"><?php echo $telefone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="Cpf" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cpf; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Placa do Carro</label>
                            <input type="text" name="PlacaCarro" class="form-control <?php echo (!empty($placacarro_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $placacarro; ?>">
                            <span class="invalid-feedback"><?php echo $placacarro_err;?></span>
                        </div>
                        <input type="hidden" name="ClienteID" value="<?php echo $clienteid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Editar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>