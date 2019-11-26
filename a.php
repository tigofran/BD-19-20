<html>
    <body>
        <h3>Inserir local</h3>
        /* latitude, longitude, nome */
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='local'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p>nome: <input type='text' name='nome'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        <h3>Remover local</h3>
        /* latitude, longitude */
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='local'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Inserir item</h3>
        /* id, descrição, localização, latitude, longitude */
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='item'/></p>
            <p>id: <input type='number' name='id'/></p>
            <p>descrição: <input type='text' name='descrição'/></p>
            <p>localização: <input type='number' name='localização'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        <h3>Remover item</h3>
        /* latitude, longitude *
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='item'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Inserir anomalia</h3>
        /* id, zona, imagem, ts, descrição, tem_anomalia_redação */
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='anomalia'/></p>
            <p>id: <input type='number' name='id'/></p>
            <p>zona: <input type='number' name='zona' max = '99'/></p>
            <p>imagem: <input type='text' name='imagem'/></p>
            <p>ts: <input type='datetime-local' name='ts'/></p>
            <p>descrição: <input type='text' name='descrição'/></p>
            
            <form action="a.php">
              <input type="checkbox" name="tem_anomalia_redação" value="true"> tem anomalia de redação<br>
              <input type="checkbox" name="tem_anomalia_redação" value="false" checked> não tem anomalia de redação<br>
            <input type="submit" value="Submit">
            </form>

            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Apagar anomalia</h3>
        /* id */
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='anomalia'/></p>
            <p>id: <input type='number' name='id'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>

<?php
    try {
        include 'config.php';

        /*Inserir e remover locais, itens e anomalias*/
        
        pg_query("start transaction");
        $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        if ($mode == "delete") {
            if ($type == "local") {
                $sql = "DELETE FROM local WHERE latitude = :latitude AND longitude = :longitude;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->execute();
            }
            if ($type == "item") {
                $sql = "DELETE FROM item WHERE latitude = :latitude AND longitude = :longitude;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->execute();
            }
            if ($type == "anomalia") {
                $sql = "DELETE FROM anomalia WHERE id = :id;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $_REQUEST['id']);
                $stmt->execute();
            }
        }
        if ($mode == "add") {
            if ($type == "local") {
                $sql = "INSERT INTO local VALUES(:latitude, :longitude, :nome);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->bindParam(':nome', $_REQUEST['nome']);
                $stmt->execute();
            }
            if ($type == "item") {
                $sql = "INSERT INTO local (latitude, longitude) VALUES(:latitude, :longitude);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->execute();

                $sql = "INSERT INTO item (id, descrição, localização)VALUES(:id, :descrição, :localização);";
                $stmt = $db->prepare($sql);
                $stml->bindParam(':id', $_REQUEST['id']);
                $stml->bindParam(':descrição', $_REQUEST['descrição']);
                $stml->bindParam(':localização', $_REQUEST['localização']);
                $stml->execute();
            }
            if ($type == "anomalia") {
                $sql = "INSERT INTO anomalia VALUES(:id, :zona, :imagem, :lingua, :ts, :descrição, :tem_anomalia_redação);";
                $stml = $db->prepare($sql);
                $stml->bindParam(':id', $_REQUEST['id']);
                $stml->bindParam(':zona', $_REQUEST['zona']);
                $stml->bindParam(':imagem', $_REQUEST['imagem']);
                $stml->bindParam(':lingua', $_REQUEST['lingua']);
                $stml->bindParam(':ts', $_REQUEST['ts']);
                $stml->bindParam(':descrição', $_REQUEST['descrição']);
                $stml->bindParam(':tem_anomalia_redação', $_REQUEST['tem_anomalia_redação']);
                $stml->execute();
            }
        }
        if($stml){ pg_query("commit");}
        else { pg_query("rollback");}
    }

    catch (PDOException $e) {
        echo("<p>ERROR: {$e->getMessage()}</p><br><a href=\"a.php\">Back</a>");
    }
?>
        
    </body>
</html>
