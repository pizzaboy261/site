<?php
require_once "db.php"; // Verbind met de db.php

// Controleer of er een bestelling-ID is meegegeven
if (!isset($_GET['id'])) {
  die("Geen bestelling ID opgegeven.");
}

$id = (int)$_GET['id']; // Haal het ID op uit de URL

// Haal de bestelling op uit de database
$bestelling = $conn->query("SELECT * FROM bestellingen WHERE id = $id")->fetch_assoc();

// Haal de gerechten op uit de database
$gerechten = $conn->query("SELECT * FROM gerechten WHERE bestelling_id = $id");

$totaal = 0; // Variabel voor het berekenen van het totaalbedrag
$btw = 0;    // Variabel voor het berekenen van de btw
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <title>Bestelling Overzicht</title>
  <link rel="stylesheet" href="style_2.css" />
</head>
<body>
  <div class="container">
    <h2>Jouw Bestelling</h2>

    <table class="bestelling-overzicht">
      <thead>
        <tr>
          <th>Gerecht</th>
          <th>Aantal</th>
          <th>Prijs per stuk</th>
          <th>Totaal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($g = $gerechten->fetch_assoc()): ?>
          <?php 
            // Bereken totaal voor dit gerecht en tel bij het totaal op
            $subtotaal = $g["prijs"] * $g["aantal"]; 
            $totaal += $subtotaal; 
          ?>
          <tr>
            <td><?= htmlspecialchars($g["naam"]) ?></td>
            <td><?= $g["aantal"] ?></td>
            <td>€<?= number_format($g["prijs"], 2, ",", ".") ?></td>
            <td>€<?= number_format($subtotaal, 2, ",", ".") ?></td>
          </tr>
        <?php endwhile; ?>

        <!-- Totaaloverzicht -->
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">Totaal excl. BTW:</td>
          <td style="font-weight:bold;">€<?= number_format($totaal, 2, ",", ".") ?></td>
        </tr>
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">21% BTW:</td>
          <td>€<?= number_format($totaal * 0.21, 2, ",", ".") ?></td>
        </tr>
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">Totaal incl. BTW:</td>
          <td style="font-weight:bold;">€<?= number_format($totaal * 1.21, 2, ",", ".") ?></td>
        </tr>

        <!-- Kamer en bezorgtijd -->
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">Kamernummer:</td>
          <td><?= htmlspecialchars($bestelling["kamernummer"]) ?></td>
        </tr>
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">Bezorgtijd:</td>
          <td><?= htmlspecialchars($bestelling["bezorgtijd"]) ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
