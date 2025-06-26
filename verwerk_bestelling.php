<?php
require_once "db.php"; // Verbind met de db.php

// Haal gegevens op uit het formulier
$kamernummer = $_POST['kamernummer'];
$bezorgtijd = $_POST['bezorgtijd'] . ' ' . $_POST['ampm']; // Voeg AM/PM toe aan tijd

// Lijst met alle producten uit het formulier
$producten = [
  ["naam" => "Pasta Bolognese", "aantal" => (int)$_POST["aantal_pasta"], "prijs" => 8.5],
  ["naam" => "Pizza Margherita", "aantal" => (int)$_POST["aantal_pizza"], "prijs" => 9.0],
  ["naam" => "Caesar Salad", "aantal" => (int)$_POST["aantal_salade"], "prijs" => 7.0],
  ["naam" => "Tomatensoep", "aantal" => (int)$_POST["aantal_soep"], "prijs" => 5.5],
];

// Aleen producten laten zien die meer dan 0 keer zijn gekozen
$gekozen = array_filter($producten, fn($p) => $p["aantal"] > 0);

// Foutmelding wanneer niks is gekozen
if (empty($gekozen)) {
  die("Geen gerechten geselecteerd.");
}

// Voeg bestelling toe aan de database
$stmt = $conn->prepare("INSERT INTO bestellingen (kamernummer, bezorgtijd) VALUES (?, ?)");
$stmt->bind_param("ss", $kamernummer, $bezorgtijd);
$stmt->execute();
$bestelling_id = $stmt->insert_id; // Haal het ID op van de zojuist ingevoerde bestelling

// Voeg de gerechten toe aan de database
$stmt = $conn->prepare("INSERT INTO gerechten (bestelling_id, naam, aantal, prijs) VALUES (?, ?, ?, ?)");
foreach ($gekozen as $gerecht) {
  $stmt->bind_param("isid", $bestelling_id, $gerecht["naam"], $gerecht["aantal"], $gerecht["prijs"]);
  $stmt->execute();
}

// Stuur door naar het overzicht van de bestelling
header("Location: overzicht.php?id=" . $bestelling_id);
exit;
?>
