<?php

session_start();

// Included configurations
include('configs/config.php');

// Check if there is an Array letters and a string tryedLetters in session
if (!isset($_SESSION['letters'])) {
    $_SESSION['letters'] = LETTERS;
}
if (!isset($_SESSION['tryedLetters'])) {
    $_SESSION['tryedLetters'] = '';
}
if (!isset($_SESSION['tryels'])) {
    $_SESSION['tryels'] = 0;
}
if (!isset($_SESSION['wordIndex'])) {
    $_SESSION['wordIndex'] = rand(0, TOTAL_WORDS);
}


// PDO => Connect to words database
$dsn = 'mysql:dbname=pendu;host=localhost';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

// Initiate word variable in session
//if (!isset($_SESSION['wordToFind'])) {
//    $_SESSION['wordToFind'] = '';
//}

// Get a word from DB
$sql = 'SELECT `word` FROM words WHERE id=:index';
$statement = $pdo->prepare($sql);

$statement->bindParam(':index', $_SESSION['wordIndex']);
$statement->execute();
$word = $statement->fetch();

var_dump($word);

$nbLetters = strlen($word['word']);

if (!isset($_SESSION['replacementString'])) {
    $_SESSION['replacementString'] = str_pad('', $nbLetters, REPLACEMENT_CHAR);
}

$found = false;
// Store the alphabet and the tryed letters in session
if (isset($_POST['triedLetter'])) {
    $triedLetter = $_POST['triedLetter'];
    $_SESSION['tryedLetters'] .= $triedLetter;
    $_SESSION['letters'][$triedLetter] = false;

// Si la lettre essayée est dans le mot il faut la remplacer à l'index de la replacmentString
    for ($i = 0; $i < $nbLetters; $i++) {
        $letter = substr($word['word'], $i, 1);
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

$howManyReplacementChar = substr_count($_SESSION['replacementString'],REPLACEMENT_CHAR,0);
var_dump($howManyReplacementChar);


if (isset($_GET['restart'])) {
    $_SESSION['wordIndex'] = rand(0, TOTAL_WORDS);
    $_SESSION['letters'] = LETTERS;
    $_SESSION['tryedLetters'] = '';
    $_SESSION['tryels'] = 0;
    $nbLetters = strlen($word['word']);
    $_SESSION['replacementString'] = str_pad('', $nbLetters, REPLACEMENT_CHAR);
}


// Require the views
require('views/start.php');