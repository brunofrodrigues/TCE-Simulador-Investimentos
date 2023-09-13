<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/processar.css">
    <title>Processar Informações</title>


</head>

<body>

    <main>
        <?php
        $dados = 0;
        if (isset($_GET['nome']) && isset($_GET['aporte_inicial']) && isset($_GET['rendimento']) && isset($_GET['meses']) && isset($_GET['aporte_mensal'])) {
            $dados = 1;
        }
        if ($dados == 0) {
            echo "insira os dados!";
        }
        if ($dados == 1) {
            require_once './classes/autoloader.class.php';
            R::setup('mysql:host=localhost;dbname=fintech', 'root', '');

            $simulação = R::dispense('simulacao');

            $simulação->nome = $_GET['nome'];
            $simulação->aporte_inicial = $_GET['aporte_inicial'];
            $simulação->rendimento = $_GET['rendimento'];
            $simulação->meses = $_GET['meses'];
            $simulação->aporte_mensal = $_GET['aporte_mensal'];

            $id = R::store($simulação);
            $simulacao = R::load('simulacao', $id);

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
                        <th>Aporte inicial</th>
                        <th>Aporte mensal</th>
                        <th>Rendimento</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>";

            $aporte_inicial = $simulacao->aporte_inicial; // Salvar o aporte inicial original
            for ($mes = 1; $mes <= $simulacao->meses; $mes++) {

                echo "<tr>";

                echo "<td> $mes </td>";
                echo "<td> $aporte_inicial</td>";
                // Verificar se é o primeiro mês (mês = 1) e definir o aporte mensal como 0
                if ($mes == 1) {
                    echo "<td> 0 </td>";
                } else {
                    echo "<td> $simulacao->aporte_mensal </td>";
                }
                echo "<td>" . $aporte_inicial * $simulacao->rendimento / 100 . "</td>";

                $aporte_inicial = ($aporte_inicial * $simulacao->rendimento / 100) + $aporte_inicial;

                echo "<td> $aporte_inicial </td>";

                if ($mes != 1) {
                    $aporte_inicial += $simulacao->aporte_mensal;
                }

                echo "</tr>";
            }
            echo "</tbody></table>";
        }
        ?>
        <br><br>
        <a href="./entrada.html">Voltar</a>
    </main>
    <footer>
        <p>&copy; 2023 - Bruno Ferreira Rodrigues & Rafaell Maurício</p>
    </footer>
</body>

</html>
