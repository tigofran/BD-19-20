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

       /*Inserir e remover locais, itens e anomalias*/

        $db->query("start transaction");

        $sql = "SELECT latitude, longitude FROM local_publico WHERE nome = :nome1;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome1', $_REQUEST['local1']);
        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $row){
            $latitude1 = $row['latitude'];
            $longitude1 = $row['longitude'];
        }

        $sql = "SELECT latitude, longitude FROM local_publico WHERE nome = :nome2;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome2', $_REQUEST['local2']);
        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $row){
            $latitude2 = $row['latitude'];
            $longitude2 = $row['longitude'];
        }

        if ($latitude1 <= $latitude2){
            $latitudemenor = $latitude1;
            $latitudemaior = $latitude2;
        }
        else {
            $latitudemenor = $latitude2;
            $latitudemaior = $latitude1;
        }

        if ($longitude1 <= $longitude2){
            $longitudemenor = $longitude1;
            $longitudemaior = $longitude2;
        }
        else {
            $longitudemenor = $longitude2;
            $longitudemaior = $longitude1;
        }

        $sql = "SELECT anomalia.id, zona, imagem, lingua, ts, anomalia.descricao, tem_anomalia_redacao FROM anomalia INNER JOIN incidencia on anomalia.id = incidencia.anomalia_id INNER JOIN item on incidencia.item_id = item.id WHERE (latitude between :latitudemenor and :latitudemaior) and (longitude between :longitudemenor and :longitudemaior);";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':latitudemenor', $latitudemenor);
        $stmt->bindParam(':latitudemaior', $latitudemaior);
        $stmt->bindParam(':longitudemenor', $longitudemenor);
        $stmt->bindParam(':longitudemaior', $longitudemaior);
        $stmt->execute();

        $result = $stmt->fetchAll();

        echo("<h3>Anomalias</h3><table border =\"0\" cellspacing=\"10\">\n");
        echo("<th><b>Id</b></th><th><b>Zona</b></th><th><b>Imagem</b></th><th><b>Lingua</b></th><th><b>ts</b></th><th><b>Descrição</b></th><th><b>Tem anomalia de redação</b></th></tr>\n");
        $i = 0;
        foreach($result as $row){
            $i++;
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

        if($i == 0){
            echo ("<p>Não existem anomalias nesta área</p>");
        }

        $db->query("commit");
    }
    
    catch (PDOException $e) {
        $db->query("rollback");
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>

        <h3>Definir locais públicos</h3>
        <form action='e.php' method='post'>
            <p>Local 1: </p>
            <?php

            echo('<select name = "local1">');
            $sqlloc = "SELECT * FROM local_publico";
            $stmtloc = $db->prepare($sqlloc);
            $stmtloc->execute();
            $result = $stmtloc->fetchAll();

            foreach($result as $row){
                echo("<option value = '$row[nome]'> $row[nome] </option>");
            }
            echo('</select>');
            ?>

            <p>Local 2: </p>
            <?php

            echo('<select name = "local2">');
            $sqlloc = "SELECT * FROM local_publico";
            $stmtloc = $db->prepare($sqlloc);
            $stmtloc->execute();
            $result = $stmtloc->fetchAll();

            foreach($result as $row){
                echo("<option value = '$row[nome]'> $row[nome] </option>");
            }
            echo('</select>');
            ?>

            <p><input type='submit' value='Submit'/></p>
        </form>
        
    </body>
</html>