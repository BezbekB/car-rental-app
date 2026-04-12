<?php
session_start();

function requireRole($roles = [])
{
      if(!isset($_SESSION['rola']) || !in_array($_SESSION['rola'], $roles))
      {
            header("Location: /WypozyczalniaSamochodow/app/site/index.php");
            exit;
      }
}

function requireLoggedIn()
{
      if(!isset($_SESSION['rola']))
      {
            header("Location: /WypozyczalniaSamochodow/app/site/index.php");
            exit;
      }
}

function requireGuest()
{
      if(isset($_SESSION['rola']))
      {
            header("Location: /WypozyczalniaSamochodow/app/site/index.php");
            exit;
      }
}
?>