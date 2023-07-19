<?php

include '../clases/consultasbd.class.php';
if (isset($_POST["key"], $_POST["insert"])) {

    $key = $_POST["key"];
    $currency = $_POST["currency"];
    $tax_base = $_POST["tax_base"];
    $tax = $_POST["tax"];
    $country = $_POST["country"];
    $lang = $_POST["lang"];
    $external = $_POST["external"];
    $confirmation = $_POST["confirmation"];
    $response = $_POST["response"];

    Insert($key, $currency, $tax_base, $tax, $country, $lang, $external, $confirmation, $response);

    header('Location: ../PanelControlPasarela.php');
}
if (isset($_POST["key"], $_POST["update"])) {

    $id = $_POST["id"];
    $key = $_POST["key"];

    Update($id, $key);
    
    header('Location: ../PanelControlPasarela.php');
}

function Insert($key, $currency, $tax_base, $tax, $country, $lang, $external, $confirmation, $response)
{
    $db = new consultasbd;
    $db->iniciarVariables();
    $db->pasarelaInsert($key, $currency, $tax_base, $tax, $country, $lang, $external, $confirmation, $response);
}

function Update($id, $key)
{
    $db = new consultasbd;
    $db->iniciarVariables();
    $db->pasarelaUpdate($id, $key);
}
