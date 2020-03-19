<?php

require 'bootstrap.php';

session_start();
// Included configurations
include('configs/config.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['totalWords'] = $query->count();
    $_SESSION['wordIndex'] = rand(0, (int)$_SESSION['totalWords'][0]);
    $_SESSION['word'] = $query->selectWord($_SESSION['wordIndex']);
    $_SESSION['nbLetters'] = strlen($_SESSION['word'][0]);
    $_SESSION['replacementString'] = str_pad('', $_SESSION['nbLetters'], REPLACEMENT_CHAR);
    $_SESSION['letters'] = LETTERS;
    $_SESSION['tryedLetters'] = '';
    $_SESSION['tryels'] = 0;
    $_SESSION['replacementString'] = str_pad('', $_SESSION['nbLetters'], REPLACEMENT_CHAR);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $found = false;
    if (isset($_POST['triedLetter'])) {
        $triedLetter = $_POST['triedLetter'];
        $_SESSION['tryedLetters'] .= $triedLetter;
        $_SESSION['letters'][$triedLetter] = false;

// Si la lettre essayée est dans le mot il faut la remplacer à l'index de la replacmentString
        for ($i = 0; $i < $_SESSION['nbLetters']; $i++) {
            $letter = substr($_SESSION['word'][0], $i, 1);
            if (strtoupper($triedLetter) === $letter) {
                $found = true;
                $_SESSION['replacementString'] = substr_replace($_SESSION['replacementString'], strtoupper($triedLetter), $i, 1);
                var_dump($_SESSION['replacementString']);
            }
        }
        if ($found === false) {
            $_SESSION['tryels']++;
        }
    }
}
$howManyReplacementChar = substr_count($_SESSION['replacementString'], REPLACEMENT_CHAR, 0);





// Require the views
require('views/start.php');