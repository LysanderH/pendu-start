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
    $_SESSION['wordIndex'] = rand(0,TOTAL_WORDS);
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


// Store the alphabet and the tryed letters in session
if (isset($_POST['triedLetter'])) {
    $triedLetter = $_POST['triedLetter'];
    $_SESSION['tryedLetters'] .= $triedLetter;
    $_SESSION['letters'][$triedLetter] = false;
}
$_SESSION['tryels'] = strlen($_SESSION['tryedLetters']);
// Require the views
require('views/start.php');