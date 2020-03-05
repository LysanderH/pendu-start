<?php

session_start();

include('configs/config.php');

if (!isset($_SESSION['letters'])) {
    $_SESSION['letters'] = LETTERS;
}
if (!isset($_SESSION['tryedLetters'])) {
    $_SESSION['tryedLetters'] = '';
}

if (isset($_POST['triedLetter'])) {
    $triedLetter = $_POST['triedLetter'];
    $_SESSION['tryedLetters'] .= $triedLetter;
    $_SESSION['letters'][$triedLetter] = false;
}



require('views/start.php');