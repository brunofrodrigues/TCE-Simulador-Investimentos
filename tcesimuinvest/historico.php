<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/historico.css">
    <title>Historico Financeiro</title>
    
</head>

<body>
    <main>
      <header>
        <h2>Desenvolvimento WEB - Simulador de Investimentos</h2>
      </header>
      <br><br>
          
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
          <br>
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
              echo "<ul>";
              echo "<li>Cliente: $simulacao->nome</li>";
              echo "<li>Aporte inicial: $simulacao->aporte_inicial</li>";
              echo "<li>Rendimento: $simulacao->rendimento</li>";
              echo "<li>Meses: $simulacao->meses</li>";
              echo "<li>Aporte mensal: $simulacao->aporte_mensal</li>";
              echo "</ul>";
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
                        echo "<tr>";
                        echo "<td>1</td>";
                        echo "<td>". number_format($simulacao->aporte_inicial, 2, ',', '.') . "</td>";
                        echo "<td>0</td>";
                        echo "<td>" . number_format($simulacao->aporte_inicial * ($simulacao->rendimento / 100), 2, ',', '.') . "</td>";
                        echo "<td>" . ($simulacao->aporte_inicial + ($simulacao->aporte_inicial * ($simulacao->rendimento / 100))) .  "</td>";
                        echo "</tr>";

                        $simulacao->aporte_inicial += ($simulacao->aporte_inicial * ($simulacao->rendimento / 100));

                        for ($mes = 2; $mes <= $simulacao->meses; $mes++) {
                            echo "<tr>";

                            echo "<td> $mes </td>";
                            echo "<td>". number_format($simulacao->aporte_inicial, 2, ',', '.') . "</td>";
                            echo "<td>" . number_format($simulacao->aporte_mensal, 2, ',', '.') . "</td>";
                            echo "<td>" . number_format($simulacao->aporte_inicial * $simulacao->rendimento / 100, 2, ',', '.') . "</td>";
                            echo "<td>" . number_format(($simulacao->aporte_inicial + $simulacao->aporte_mensal) + ($simulacao->aporte_inicial * ($simulacao->rendimento / 100)), 2, ',', '.') .  "</td>";

                            $simulacao->aporte_inicial += $simulacao->aporte_mensal + ($simulacao->aporte_inicial * ($simulacao->rendimento / 100));

                            echo "</tr>";
                        }
                    echo "</tbody></table>";
                  
              }
            }                                
        ?>

        <br><br>
          
        <a href="index.html">Voltar</a>

    </main>
    <footer>
        <p>&copy; 2023 - Bruno Ferreira Rodrigues & Rafaell Maurício</p>
    </footer>
</body>

</html>