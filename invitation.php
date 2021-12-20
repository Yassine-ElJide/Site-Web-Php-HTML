<?php
session_start();
session_regenerate_id();
include_once('db.php');
include_once('isConnected.php');
if(isset($_POST['invitation_btn']) && !empty($_POST['destinataire'])){
    $message = $_POST['message'];
    $destinataire = $_POST['destinataire'];
    $expediteur = $_SESSION['login'];
    $dateinscription = $_POST['dateinscription'] ;
    $numevenement = $_POST['invitation_btn'];
    $requete = $db->prepare("INSERT INTO invitation(message, loginexpediteur, logindestinataire, dateinscription, numevenement) VALUES ('{$message}', '{$expediteur}', '{$destinataire}', '{$dateinscription}', '{$numevenement}')");
    $requete->execute();
}


header('location: profil.php');
