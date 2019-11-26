<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>

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
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        if ($type == "incidencia") {
            $sql = "INSERT INTO local_publico VALUES(:latitude, :longitude, :nome);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':latitude', $_REQUEST['latitude']);
            $stmt->bindParam(':longitude', $_REQUEST['longitude']);
            $stmt->execute();
        }
               }
        if ($type == "item") {
            $sql = "INSERT INTO local_publico (latitude, longitude) VALUES(:latitude, :longitude);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':latitude', $_REQUEST['latitude']);
            $stmt->bindParam(':longitude', $_REQUEST['longitude']);
            $stmt->execute();

            $sql = "INSERT INTO item (id, descricao, localizacao)VALUES(:id, :descricao, :localizacao);";
            $stmt = $db->prepare($sql);
            $stml->bindParam(':id', $_REQUEST['id']);
            $stml->bindParam(':descricao', $_REQUEST['descricao']);
            $stml->bindParam(':localizacao', $_REQUEST['localizacao']);
            $stml->execute();
        }
    $db->query("commit");
    }
    
    catch (PDOException $e) {
        $db->query("rollback");
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>

    <body>
        <h3>Registar incidência</h3>
        <form action='d.php' method='post'>
            <p><input type='hidden' name='type' value='incidencia'/></p>
            <p>ID da anomalia: <input type='number' name='anomalia_id' min = '0'/></p>
            <p>ID do item: <input type='number' name='item_id' min = '0'/></p>
            <p>email: <input type='text' name='email'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Registar duplicados</h3>
        <form action='d.php' method='post'>
            <p><input type='hidden' name='type' value='duplicado'/></p>
            <p>ID do item 1: <input type='number' id = 'item1' name='item1' min = '0'/></p>
            <p>ID do item 2: <input type='number' id = 'item2' name='item2' min = '0'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        <script>
            function setMin() {
                var item1 = document.getElementById("item1");
                var item2 = document.getElementById("item2");
                item2.min = item1.value;
            }
            var trigger = document.getElementById("item1");
            trigger.addEventListener("change", setMin, false);
        </script>   
    </body>
</html>
