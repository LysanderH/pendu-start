<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= SITE_TITLE; ?></title>
</head>
<body>
<div>
    <h1>Trouve le mot en moins de 8 coups !</h1>
</div>
<div>
    <p>Le mot à deviner compte 9 lettres&nbsp;: *********</p>
</div>
<div>
    <img src="images/pendu0.gif"
         alt="">
</div>
<div>
    <p>Voici les lettres que tu as déjà essayées&nbsp;: <?= $_SESSION['tryedLetters']; ?></p>
</div>
<form action="index.php"
      method="post">
    <fieldset>
        <legend>Il te reste 8 essais pour sauver ta peau
        </legend>
        <div>
            <label for="triedLetter">Choisis ta lettre</label>
            <select name="triedLetter"
                    id="triedLetter">
                <?php foreach ($_SESSION['letters'] as $letter => $val): ?>
                    <?php if ($val): ?>
                        <option value="<?= $letter ?>"><?= $letter; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <input type="submit"
                   value="Essayer cette lettre">
        </div>
    </fieldset>
</form>
</body>
</html>