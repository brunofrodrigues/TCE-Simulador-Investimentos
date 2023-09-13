<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico</title>
</head>

<body>

    <main>
          
        <form action="historico.php" method="get">
          <?php 
          if (isset($_GET['id']))
          {
            echo "id: <input type='number' name='id' id='id' value='{$_GET['id']}'\>";
          } 
          else
          {
            echo "id: <input type='number' name='id' id='id'\>";
          }
          ?>
          <input type="submit" value="buscar">
        </form>

        <?php
          require_once './classes/autoloader.class.php';

          if(isset($_GET["id"])){
            R::setup('mysql:host=localhost;dbname=fintech', 'root', '');

            $simulacao = R::load('simulacao', $_GET["id"]);

            if (!isset($simulacao->nome)){
              echo "Id não encontrado!";
            }
            else
            {
              echo $simulacao->id;
              echo $simulacao->nome;
              echo $simulacao->aporte_inicial;
              echo $simulacao->rendimento;
              echo $simulacao->aporte_mensal;
              echo $simulacao->meses;

              echo "<table><thead>
                    <tr>
                        <th>Mês</th>
                        <th>Aporte inicial </th>
                        <th>Aporte mensal</th>
                        <th>Rendimento</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>";         
                        for ($mes = 1; $mes <= $simulacao->meses; $mes++) {
                            echo "<tr>";

                            echo "<td> $mes </td>";
                            echo "<td> $simulacao->aporte_inicial</td>";
                            echo "<td> $simulacao->aporte_mensal </td>";
                            echo "<td> {($simulacao->aporte_inicial * $simulacao->rendimento ) / 100} </td>";

                            $simulacao->aporte_inicial = ($simulacao->aporte_inicial * $simulacao->rendimento / 100) + $simulacao->aporte_inicial;

                            echo "<td> $simulacao->aporte_inicial </td>";

                            $simulacao->aporte_inicial += $simulacao->aporte_mensal;

                            echo "</tr>";
                        }
                    echo "</tbody></table>";
              }
            }                                
        ?>
      
        </fieldset>
          
        <a href="index.html">Voltar</a>
    </main>
    
</body>

</html>