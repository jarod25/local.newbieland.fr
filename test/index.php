<?php
if (isset($_POST['poids']) && isset($_POST['taille']) && isset($_POST['sexe'])) {
    $poids = $_POST['poids'];
    $taille = $_POST['taille'];
    $sexe = $_POST['sexe'];
    $taille = $taille / 100;
    $imc = $poids / ($taille * $taille);
    echo "Votre IMC est de " . $imc . "<br>";
    if ($sexe == "homme") {
        if ($imc < 20) {
            echo "Vous êtes en dessous de votre poids idéal";
        } elseif ($imc >= 20 && $imc <= 25) {
            echo "Vous êtes dans votre poids idéal";
        } elseif ($imc > 25) {
            echo "Vous êtes au dessus de votre poids idéal";
        }
    } elseif ($sexe == "femme") {
        if ($imc < 19) {
            echo "Vous êtes en dessous de votre poids idéal";
        } elseif ($imc >= 19 && $imc <= 24) {
            echo "Vous êtes dans votre poids idéal";
        } elseif ($imc > 24) {
            echo "Vous êtes au dessus de votre poids idéal";
        }
    }
}
?>