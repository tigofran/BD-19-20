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
            $sql = "INSERT INTO incidencia (anomalia_id) VALUES(:anomalia_id);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':anomalia_id', $_REQUEST['anomalia_id']);
            $stmt->execute();
    
            $sql = "INSERT INTO proposta_de_correcao (nro, data_hora, texto) VALUES(:nro, :data_hora, :texto);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nro', $_REQUEST['nro']);
            $stmt->bindParam(':data_hora', $_REQUEST['data_hora']);
            $stmt->bindParam(':texto', $_REQUEST['texto']);
            $stmt->execute();

            $sql = "INSERT INTO utilizador_qualificado (email) VALUES(:email);";
            $stmt = $db->prepare($sql);
            $stml->bindParam(':email', $_REQUEST['email']);
            $stml->execute();
        }
        if ($mode == "edit") {
             if ($type == "correcao") {
                $sql = "UPDATE correcao SET email = :email2, nro = :nro2, anomalia_id = :anomalia_id2 WHERE email = :email AND nro = :nro AND anomalia_id = :anomalia_id;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':email', $_REQUEST['email']);
                $stmt->bindParam(':nro', $_REQUEST['nro']);
                $stmt->bindParam(':anomalia_id', $_REQUEST['anomalia_id']);
                $stmt->bindParam(':email2', $_REQUEST['email2']);
                $stmt->bindParam(':nro2', $_REQUEST['nro2']);
                $stmt->bindParam(':anomalia_id2', $_REQUEST['anomalia_id2']);
                $stmt->execute();                
            }
            if ($type == "proposta_de_correcao") {
                $sql = "UPDATE proposta_de_correcao SET texto = :texto WHERE email = :email AND nro = :nro;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':texto', $_REQUEST['texto']);
                $stmt->bindParam(':email', $_REQUEST['email']);
                $stmt->bindParam(':nro', $_REQUEST['nro']);
                $stmt->execute();
            }
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
            <p>data_hora: <input type='datetime-local' name='data_hora'/></p>
            <p>texto: <input type='text' name='texto'/></p>
            <p><input type='submit' value='Submit'/></p>
        </form>

        <h3>Editar correção</h3>
        <form action='b.php' method='post'>
            <p><input type='hidden' name='mode' value='edit'/></p>
            <p><input type='hidden' name='type' value='proposta_de_correcao'/></p>
            <p>email: <input type='text' name='email'/></p>
            <p>numero: <input type='number' name='nro' min = '0'/></p>
            <p>id da anomalia: <input type='number' min = '0' name='anomalia_id'/></p>
            <p>novo email: <input type='text' name='email2'/></p>
            <p>novo numero: <input type='number' name='nro2' min = '0'/></p>
            <p>novo id da anomalia: <input type='number' min = '0' name='anomalia_id2'/></p>
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
