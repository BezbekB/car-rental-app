<?php
require_once('../../../config/auth.php');
requireRole(['admin']);
require_once('../../../config/db.php');

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'], $_POST['rola']))
{
      $stmt = $pdo->prepare("UPDATE Uzytkownik SET RolaID = ? WHERE UzytkownikID = ?");
      $stmt->execute([$_POST['rola'], $_POST['id']]);
}

$stmt = $pdo->prepare("SELECT Uzytkownik.UzytkownikID as Id, Login, Imie, Nazwisko, Email, Rola FROM Osoba JOIN Uzytkownik ON Osoba.UzytkownikID = Uzytkownik.UzytkownikID JOIN Rola ON Uzytkownik.RolaID = Rola.RolaID");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$roles = $pdo->query("SELECT * FROM Rola")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Zarządzanie Użytkownikami</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>

<main class="admin-users-main">
      <h1 class="admin-users-title">Zarządzanie Użytkownikami</h1>

      <table class="admin-users-table">
            <thead>
                  <th>UżytkownikID</th>
                  <th>Login</th>
                  <th>Imię</th>
                  <th>Nazwisko</th>
                  <th>Email</th>
                  <th>Rola</th>
                  <th>Edytuj</th>
            </thead>

            <tbody>
                  <?php foreach($data as $record): ?>
                        <tr>
                              <td><?= $record['Id'] ?></td>
                              <td><?= $record['Login'] ?></td>
                              <td><?= $record['Imie'] ?></td>
                              <td><?= $record['Nazwisko'] ?></td>
                              <td><?= $record['Email'] ?></td>

                              <td>
                                    <form method="POST" class="role-form">
                                          <input type="hidden" name="id" value="<?= $record['Id'] ?>">

                                          <select name="rola" class="role-select">
                                                <?php foreach ($roles as $r): ?>
                                                <option value="<?= $r['RolaID'] ?>"
                                                      <?= $r['Rola'] == $record['Rola'] ? 'selected' : '' ?>>
                                                      <?= $r['Rola'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                          </select>
                              </td>

                              <td>
                                          <button type="submit" class="save-role-btn">Zmień Rolę</button>
                                    </form>
                              </td>
                        </tr>
                  <?php endforeach; ?>
            </tbody>
      </table>
</main>

<?php require_once('../../components/footer.php'); ?>
</body>
</html>