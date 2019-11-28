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

        $latitudemin = $_REQUEST['latitude'] - $_REQUEST['dx'];
        $latitudemax = $_REQUEST['latitude'] + $_REQUEST['dx'];
        $longitudemin = $_REQUEST['longitude'] - $_REQUEST['dy'];
        $longitudemax = $_REQUEST['longitude'] + $_REQUEST['dy'];

        $sql = "SELECT anomalia.id, zona, imagem, lingua, ts, anomalia.descricao, tem_anomalia_redacao FROM anomalia INNER JOIN incidencia on anomalia.id = incidencia.anomalia_id INNER JOIN item on incidencia.item_id = item.id WHERE (latitude between :latitudemin and :latitudemax) and (longitude between :longitudemin and :longitudemax) and (ts > :mindate);";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mindate', $mindate);
        $stmt->bindParam(':latitudemin', $latitudemin);
        $stmt->bindParam(':latitudemax', $latitudemax);
        $stmt->bindParam(':longitudemin', $longitudemin);
        $stmt->bindParam(':longitudemax', $longitudemax);
        $stmt->execute();
        $result = $stmt->fetchAll();

        echo("<h3>Anomalias</h3><table border =\"0\" cellspacing=\"10\">\n");
        echo("<th><b>Id</b></th><th><b>Zona</b></th><th><b>Imagem</b></th><th><b>Lingua</b></th><th><b>ts</b></th><th><b>Descrição</b></th><th><b>Tem anomalia de redação</b></th></tr>\n");
        foreach($result as $row){
            echo("<tr><td>");
            echo($row['id']);
            echo("</td><td>");
            echo($row['zona']);
            echo("</td><td>");
            echo($row['imagem']);
            echo("</td><td>");
            echo($row['lingua']);
            echo("</td><td>");
            echo($row['ts']);
            echo("</td><td>");
            echo($row['descricao']);
            echo("</td><td>");
            echo($row['tem_anomalia_redacao']);
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

        <form action='f.php' method='post'>
            <h3>Definir coordenadas</h3>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <h3>Definir intervalo de coordenadas</h3>
            <p>intervalo de latitude: <input type='number' name='dx' min = '-90' max = '90' step='0.01'/></p>
            <p>intervalo de longitude: <input type='number' name='dy' min = '-180' max = '180' step='0.01'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
    </body>
</html>
