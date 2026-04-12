<?php
require_once(__DIR__ . '/../../config/auth.php');
?>
<header>
      <div class="logo-box">
            <img src="/WypozyczalniaSamochodow/app/site/assets/img/logo.png" alt="Logo Carenteo" class="logo">
            <h3 class="title">Carenteo</h3>
      </div>

<nav>
      <?php if(!isset($_SESSION['rola'])): ?>
            <a href="/WypozyczalniaSamochodow/app/site/index.php">Strona Główna</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/common/search_cars.php">Samochody</a>

            <div class="account-dropdown">
                  <a class="account-btn">Konto</a>
                  <div class="dropdown-menu">
                  <a href="/WypozyczalniaSamochodow/app/site/account/login.php">Zaloguj się</a>
                  <a href="/WypozyczalniaSamochodow/app/site/account/register.php">Zarejestruj się</a>
                  </div>
            </div>

      <?php elseif($_SESSION['rola'] === 'klient'): ?>
            <a href="/WypozyczalniaSamochodow/app/site/index.php">Strona Główna</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/common/search_cars.php">Samochody</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/klient.php">Panel klienta</a>

            <div class="account-dropdown">
                  <a class="account-btn">Moje konto</a>
                  <div class="dropdown-menu">
                  <a href="/WypozyczalniaSamochodow/app/site/dashboards/customer/customer_settings.php">Moje konto</a>
                  <a href="/WypozyczalniaSamochodow/app/site/account/logout.php">Wyloguj się</a>
                  </div>
            </div>

      <?php elseif($_SESSION['rola'] === 'pracownik'): ?>
            <a href="/WypozyczalniaSamochodow/app/site/index.php">Strona Główna</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/common/search_cars.php">Samochody</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/pracownik.php">Panel pracownika</a>

            <div class="account-dropdown">
                  <a class="account-btn">Moje konto</a>
                  <div class="dropdown-menu">
                  <a href="/WypozyczalniaSamochodow/app/site/dashboards/employee/employee_settings.php">Moje konto</a>
                  <a href="/WypozyczalniaSamochodow/app/site/account/logout.php">Wyloguj się</a>
                  </div>
            </div>

      <?php elseif($_SESSION['rola'] === 'admin'): ?>
            <a href="/WypozyczalniaSamochodow/app/site/index.php">Strona Główna</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/common/search_cars.php">Samochody</a>
            <a href="/WypozyczalniaSamochodow/app/site/dashboards/admin.php">Panel admina</a>

            <div class="account-dropdown">
                  <a class="account-btn">Moje konto</a>
                  <div class="dropdown-menu">
                  <a href="/WypozyczalniaSamochodow/app/site/dashboards/common/change_password.php">Moje konto</a>
                  <a href="/WypozyczalniaSamochodow/app/site/account/logout.php">Wyloguj się</a>
                  </div>
            </div>

      <?php endif; ?>
</nav>

</header>