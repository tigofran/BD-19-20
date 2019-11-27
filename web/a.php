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
        $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        if ($mode == "delete") {
            if ($type == "local") {
                $sql = "DELETE FROM local_publico WHERE nome = :nome;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':nome', $_REQUEST['nome']);
                $stmt->execute();
            }
            if ($type == "item") {
                $sql = "DELETE FROM item WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $_REQUEST['id']);
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
                $sql = "INSERT INTO local_publico (latitude, longitude, nome) VALUES(:latitude, :longitude, :nome);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->bindParam(':nome', $_REQUEST['nome']);
                $stmt->execute();
            }
            if ($type == "item") {
                $sql = "INSERT INTO local_publico (latitude, longitude) VALUES(:latitude, :longitude);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':latitude', $_REQUEST['latitude']);
                $stmt->bindParam(':longitude', $_REQUEST['longitude']);
                $stmt->execute();

                $sql = "INSERT INTO item (descricao, localizacao) VALUES(:descricao, :localizacao);";
                $stmt = $db->prepare($sql);
                $stml->bindParam(':descricao', $_REQUEST['descricao']);
                $stml->bindParam(':localizacao', $_REQUEST['localizacao']);
                $stml->execute();
            }
            if ($type == "anomalia") {
                $sql = "INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES(:zona, :imagem, :lingua, :ts, :descricao, :tem_anomalia_redacao);";
                $stml = $db->prepare($sql);
                $var = '((' . $_REQUEST['x1'] . ',' . $_REQUEST['y1'] .'), (' . $_REQUEST['x2'] .',' . $_REQUEST['y2'] . '))';
                $stml->bindParam(':zona', $var);
                $stml->bindParam(':imagem', $_REQUEST['imagem']);
                $stml->bindParam(':lingua', $_REQUEST['lingua']);
                $var2 = str_replace('T', ' ', $_REQUEST['ts']);
                $var2 = $var2 . ':00';
                $stml->bindParam(':ts', $var2);
                $stml->bindParam(':descricao', $_REQUEST['descricao']);
                $stml->bindParam(':tem_anomalia_redacao', $_REQUEST['tem_anomalia_redacao']);
                $stml->execute();
            }
        }
    $db->query("commit");
    }
    
    catch (PDOException $e) {
        $db->query("rollback");
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>

        <h3>Inserir local</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='local'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p>nome: <input type='text' name='nome'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Remover local</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='local'/></p>
            <p>nome: <input type='text' name='nome'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Inserir item</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='item'/></p>
            <p>descrição: <input type='text' name='descricao'/></p>
            <p>localização: <input type='text' name='localizacao'/></p>
            <p>latitude: <input type='number' name='latitude' min = '-90' max = '90' step='0.000001'/></p>
            <p>longitude: <input type='number' name='longitude' min = '-180' max = '180' step='0.000001'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Remover item</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='item'/></p>
            <p>id: <input type='number' name='id' min = '0'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Inserir anomalia</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p><input type='hidden' name='type' value='anomalia'/></p>
            <p>zona:</p>
            <p>x1: <input type='number' name='x1'/></p>
            <p>x2: <input type='number' name='x2'/></p>
            <p>y1: <input type='number' name='y1'/></p>
            <p>y2: <input type='number' name='y2'/></p>
            <p>imagem: <input type='text' name='imagem'/></p>
            <p>ts: <input type='datetime-local' name='ts' max="2020-09-16T00:30"/></p>
            <p>lingua: <input type='text' name='lingua'/></p>
            <p>descrição: <input type='text' name='descricao'/></p>
            <input type="radio" name="tem_anomalia_redacao" value="true"> tem anomalia de redação<br>
            <input type="radio" name="tem_anomalia_redacao" value="false" checked> não tem anomalia de redação<br>
            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Apagar anomalia</h3>
        <form action='a.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p><input type='hidden' name='type' value='anomalia'/></p>
            <p>id: <input type='number' name='id'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
    </body>
</html>
