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

       /*Listar utilizadores*/

        $db->query("start transaction");
        $sql = "SELECT * FROM utilizador";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        echo("<h3>Utilizadores</h3><table border =\"0\" cellspacing=\"10\">\n");
        echo("<tr><th><b>Email</b></th><th><b>Pass</b></th></tr>\n");
        foreach($result as $row){
            echo("<tr><td>");
            echo($row['email']);
            echo("</td><td>");
            echo($row['pass']);
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
    </body>
</html>
