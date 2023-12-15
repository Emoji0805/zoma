<?php
function dbconnect()
{
    $bdd = null;
    if ($bdd === null) {
        $bdd = mysqli_connect('localhost', 'root', '', 'vente');
    }
    return $bdd;
}

function getConnectionPDOPost()
{
    try {
        $dsn = "pgsql:host='localhost';port='5432';dbname='postgres'";
        $dbh = new PDO($dsn, 'postgres', 'toky');
        return $dbh;
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage();
        die();
    }
}
