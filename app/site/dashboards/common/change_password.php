<?php
require_once('../../../config/auth.php');
requireLoggedIn();
require_once('../../../config/db.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $password = trim($_POST['password']);
      $passwordRepeat = trim($_POST['passwordRepeat']);

      $errors = [];

      if(strlen($password) < 6) $errors[] = "Nowe hasło musi mieć min. 6 znaków";
      
      if($password != $passwordRepeat) $errors[] = "Hasła muszą być takie same";

      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      if(empty($errors))
      {
            try{
                  $stmt = $pdo->prepare("UPDATE Uzytkownik SET Haslo = ? WHERE UzytkownikID = ?");
                  $stmt->execute([$passwordHash, $_SESSION['user_id']]);
                  $success = "Udało się zmienić hasło!";
            }
            catch(Exception $e)
            {
                  $errors[] = "Błąd podczas zmiany hasła: " . $e->getMessage();
            }
      }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Zmiana Hasła</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <form action="" method="POST" autocomplete="off">
            <h1>Zmiana Hasła</h1>
            <input type="password" name="password" placeholder="Nowe Hasło" autocomplete="off">
            <input type="password" name="passwordRepeat" placeholder="Powtórz Nowe Hasło" autocomplete="off">
            <button type="submit">Zmień Hasło</button>
            <?php if(isset($errors)):?>
                  <ul class="error-list">
                        <?php foreach($errors as $error): ?>
                              <li><?= $error ?></li>
                        <?php endforeach; ?>
                  </ul>
            <?php endif; ?>
            <?php if(isset($success)): ?>
                  <p class="success"><?= $success ?></p>
            <?php endif; ?>
      </form>  
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>