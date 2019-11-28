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

        /*Registar incidências e duplicados*/
        
        $db->query("start transaction");
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        if ($type == "incidencia") {
            $sql = "INSERT INTO incidencia (anomalia_id, item_id, email) VALUES(:anomalia_id, :item_id, :email);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':anomalia_id', $_REQUEST['anomalia_id']);
            $stmt->bindParam(':item_id', $_REQUEST['item_id']);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->execute();
        }

        if ($type == "duplicado") {
            $sql = "INSERT INTO duplicado (item1, item2) VALUES(:item1, :item2);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':item1', $_REQUEST['item1']);
            $stmt->bindParam(':item2', $_REQUEST['item2']);
            $stmt->execute();
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
            <p>ID da anomalia: </p>
            <?php

            echo('<select name = "anomalia_id">');
            $sql = "SELECT id FROM anomalia;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row){
                echo("<option value = '$row[id]'> $row[id] </option>");
            }
            echo('</select>');
            ?>

            <p>ID do item: </p>

            <?php
            echo('<select name = "item_id">');
            $sql = "SELECT id FROM item;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row){
                echo("<option value = '$row[id]'> $row[id] </option>");
            }
            echo('</select>');
            ?>

            <p>email: </p>

            <?php
            echo('<select name = "email">');
            $sqlid = "SELECT email FROM utilizador;";
            $stmtid = $db->prepare($sqlid);
            $stmtid->execute();
            $result = $stmtid->fetchAll();

            foreach($result as $row){
                echo("<option value = '$row[email]'> $row[email] </option>");
            }
            echo('</select>');
            ?>

            <p><input type='submit' value='Submit'/></p>
        </form>
        
        <h3>Registar duplicados</h3>
        <form action='d.php' method='post'>
            <p><input type='hidden' name='type' value='duplicado'/></p>
            <?php
            $sql = "SELECT id FROM item WHERE id >= all(SELECT id FROM item);";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row){
                $max = $row['id'];
                $max2 = $max--;
            }
            ?>

            <p>ID do item 1: <input type='number' id = 'item1' name='item1' min = '0'/></p>
            <p>ID do item 2: <input type='number' id = 'item2' name='item2' min = '0'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
        <script>
            function setMin() {
                var item1 = document.getElementById("item1");
                var item2 = document.getElementById("item2");
                item1.max = "<?php echo $max ?>";
                item2.max = "<?php echo $max2 ?>";
                var i = item1.value;
                i++;
                item2.min = i;
                item1.min = 1;
            }
            var trigger = document.getElementById("item1");
            trigger.addEventListener("change", setMin, false);
        </script>  
    </body>
</html>
