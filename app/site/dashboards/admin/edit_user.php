<?php
require_once('../../../config/auth.php');
requireRole(['admin']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT Uzytkownik.UzytkownikID AS Id,Login, Email, Rola,Imie, Nazwisko, Pensja FROM Osoba JOIN Uzytkownik ON Osoba.UzytkownikID = Uzytkownik.UzytkownikID JOIN Rola ON Uzytkownik.RolaID = Rola.RolaID WHERE Uzytkownik.UzytkownikID = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $pensja = $_POST['pensja'];

    $pdo->prepare("UPDATE Osoba SET Pensja=? WHERE UzytkownikID=?")->execute([$pensja, $id]);

    header("Location: ./manage_users.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Edytuj pensję</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>

<?php require_once('../../components/header.php'); ?>

<main class="account-main">
      <h1>Edytuj pensję pracownika</h1>

      <form method="POST" class="account-form">

            <label>Pensja</label>
            <input type="number" step="0.01" name="pensja" value="<?= $user['Pensja'] ?>" required>

            <button type="submit" class="save-role-btn">Zapisz zmiany</button>
      </form>
</main>

<?php require_once('../../components/footer.php'); ?>
</body>
</html>
