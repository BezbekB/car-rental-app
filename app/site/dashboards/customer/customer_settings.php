<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Konto Klienta</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
      <?php require_once('../../components/header.php'); ?>
      <main class="admin-customer-main">
      <h1>Moje konto</h1>

      <div class="admin-customer-grid">
            <a href="../common/change_data.php" class="admin-customer-card">
                  <h2>Dane Osobowe</h2>
                  <p>Zarządzaj danymi osobowymi</p>
            </a>
            <a href="../common/change_password.php" class="admin-customer-card">
                  <h2>Zmiana Hasła</h2>
                  <p>Zmień swoje hasło</p>
            </a>

      </div>
      </main>
      <?php require_once('../../components/footer.php'); ?>
</body>
</html>
