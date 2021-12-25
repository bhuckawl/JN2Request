<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Cadastro de Clientes</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Cadastro de Clientes</a>
                    </div>
                    <?php
                    // Inclui arquivo config
                    require_once "config.php";
                    
                    // Executa a query clientes
                    $sql = "SELECT * FROM clientes";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Telefone</th>";
                                        echo "<th>Cpf</th>";
                                        echo "<th>Placa do Carro</th>";
                                        echo "<th>Ação</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['ClienteID'] . "</td>";
                                        echo "<td>" . $row['Nome'] . "</td>";
                                        echo "<td>" . $row['Telefone'] . "</td>";
                                        echo "<td>" . $row['Cpf'] . "</td>";
                                        echo "<td>" . $row['PlacaCarro'] . "</td>";
                                        echo "<td>";
                                        echo '<a href="read.php?ClienteID='. $row['ClienteID'] .'" class="mr-3" title="Ver Dados" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                        echo '<a href="update.php?ClienteID='. $row['ClienteID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                        echo '<a href="delete.php?ClienteID='. $row['ClienteID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Final do resultado
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Nenhum registro cadastrado.</em></div>';
                        }
                    } else{
                        echo "Aconteceu algum problema tente novamente.";
                    }
 
                    // Fecha conexão
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>