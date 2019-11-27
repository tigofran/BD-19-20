<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>

<?php
    try {
        $host = "db.ist.utl.pt";
        $user ="ist189546";
        $password = "projetobd";
        $dbname = $user;
        
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Listar anomalias nos ultimos 3 meses que ocorreram a +- intervalo das coordenadas*/

        $db->query("start transaction");
        $mindate = date("Y-m-d h:m:s", strtotime("-3 months"));
        $stmt->bindParam(':mindate', $mindate);
        $sql = "SELECT * FROM anomalia WHERE ts > :mindate;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        echo("<h3>anomalias</h3><table border =\"1\">\n");
        echo("<tr><td><b>id</b></td><td><b>imagem</b></td><td><b>lingua</b></td><td><b>ts</b></td><td><b>descrição</b></td><td><b>tem_anomalia_redacao</b></td><td><b>zona</b></td></tr>\n");
        foreach($result as $row){
            echo("<tr><td>");
            echo($row['id']);
            echo("</td><td>");
            echo($row['imagem']);
            echo("</td><td>");
            echo($row['lingua']);
            echo("</td><td>");
            echo($row['ts']);
            echo("</td><td>");
            echo($row['descricao']);
            echo("</td><td>");
            echo($row['tem_anomalia_redacao']);echo("</td><td>");
            echo($row['zona']);
            echo("</td></tr>\n");
        }
        echo("</table>\n");
        $db->query("commit");

    }
    
    catch (PDOException $e) {
        $db->query("rollback");
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>

        <form action='a.php' method='post'>
            <h3>Definir coordenadas</h3>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <h3>Definir intervalo de coordenadas</h3>
            <p>intervalo de latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.01'/></p>
            <p>intervalo de longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.01'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
    </body>
</html>
