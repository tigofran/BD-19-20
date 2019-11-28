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

         /* Inserir, editar e remover correcções e propostas de correcção*/
        
        $db->query("start transaction");
        $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        if ($mode == "delete") {
            $sql = "DELETE FROM correcao WHERE email = :email AND nro = :nro;";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
            $stmt->execute();
            $sql = "DELETE FROM proposta_de_correcao WHERE email = :email AND nro = :nro;";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
            $stmt->execute();
        }
        if ($mode == "add") {
            $sql = "INSERT INTO proposta_de_correcao (email, nro, data_hora, texto) VALUES(:email, :nro, :data_hora, :texto);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
            $stmt->bindParam(':data_hora', $_REQUEST['data_hora']);
            $stmt->bindParam(':texto', $_REQUEST['texto']);
            $stmt->execute();

            $sql = "INSERT INTO correcao (email, nro, anomalia_id) VALUES(:email, :nro, :anomalia_id);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
            $stmt->bindParam(':anomalia_id', $_REQUEST['anomalia_id']);
            $stmt->execute();
    
        }
        if ($mode == "edit") {
            $sql = "UPDATE proposta_de_correcao SET texto = :texto WHERE email = :email AND nro = :nro;";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':texto', $_REQUEST['texto']);
            $stmt->bindParam(':email', $_REQUEST['email']);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
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
        <form action='b.php' method='post'>
            <h3>Inserir correção e proposta de correção</h3>
            <p><input type='hidden' name='mode' value='add'/></p>
            <p>email: <input type='text' name='email'/></p>
            <p>id da anomalia: <input type='number' min = '0' name='anomalia_id'/></p>
            <p>numero da anomalia: <input type='number' min = '0' name='nro'/></p>
            <p>data_hora: <input type='datetime-local' name='data_hora'/></p>
            <p>texto: <input type='text' name='texto'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
       
        <h3>Editar texto da proposta de correção</h3>
        <form action='b.php' method='post'>
            <p><input type='hidden' name='mode' value='edit'/></p>
            <p><input type='hidden' name='type' value='proposta_de_correcao'/></p>
            <p>novo texto: <input type='text' name='texto'/></p>
            <p>email: <input type='text' name='email'/></p>
            <p>numero: <input type='number' name='nro' min = '0'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Remover correção e proposta de correção </h3>
        <form action='b.php' method='post'>
            <p><input type='hidden' name='mode' value='delete'/></p>
            <p>email: <input type='text' name='email'/></p>
            <p>numero: <input type='number' name='nro' min = '0'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>
    </body>
</html>
