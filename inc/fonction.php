<?php
include("connexion.php");

function insererVente($date, $produit, $quantite)
{
    $validation = false;
    $sql = "insert into vente values (null,'$date','$produit',$quantite)";
    if (mysqli_query(dbconnect(), $sql)) {
        $validation = true;
    }
    return $validation;
}

function getListeVente()
{
    $venteListe = array(); // Create an array to store the sales data

    $conn = dbconnect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM vente";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $venteListe[] = $row;
    }

    mysqli_close($conn);

    $jsonResult = json_encode($venteListe);

    return $jsonResult;
}

function getListeProduitByCategorie($categorie)
{
    $venteListe = array();

    $conn = dbconnect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT p.*
            FROM produit p
            JOIN categorie c ON p.idCategorie = c.idCategorie
            WHERE c.nom = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categorie);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $venteListe[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $jsonResult = json_encode($venteListe);

    return $jsonResult;
}

function getListeCategorie()
{
    $venteListe = array();

    $conn = dbconnect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM categorie";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $venteListe[] = $row;
    }

    mysqli_close($conn);

    $jsonResult = json_encode($venteListe);

    return $jsonResult;
}

function getProduitPDO()
{
    try {
        $dbh = getConnectionPDOPost();

        $query = "SELECT * FROM produit";
        $stmt = $dbh->query($query);
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dbh = null;

        $jsonResult = json_encode($produits);

        return $jsonResult;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des produits: " . $e->getMessage());
    }
}


function getListeVentePDO()
{
    try {
        $dbh = getConnectionPDOPost();

        $query = "SELECT * FROM vente";
        $stmt = $dbh->query($query);
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dbh = null;

        $jsonResult = json_encode($produits);

        return $jsonResult;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des produits: " . $e->getMessage());
    }
}

function insererVentePDO($date, $produit, $quantite)
{
    try {
        $dbh = getConnectionPDOPost();

        $sql = "INSERT INTO vente (date, produit, quantite) VALUES (:date, :produit, :quantite)";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':produit', $produit);
        $stmt->bindParam(':quantite', $quantite);

        $validation = $stmt->execute();

        $dbh = null;

        return $validation;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de l'insertion de la vente : " . $e->getMessage());
    }
}

function supprimer($id)
{
    $sql = "DELETE FROM vente WHERE idvente =$id";
    $query = mysqli_query(dbconnect(), $sql);
    return;
}
