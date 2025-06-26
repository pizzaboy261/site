// Functie om de dropbox voor het aantal te tonen/verbergen
function toggleAantal(id) {
  const dropdown = document.getElementById('aantal-' + id);
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Wacht tot de pagina helemaal geladen is
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('bestelform');       // Haal het formulier op
  const foutmelding = document.getElementById('foutmelding'); // Foutmelding laten zien wanneer er niks is ingevuld

  // Event wanneer er op bestellen word gedrukt
  form.addEventListener('submit', function (e) {
    foutmelding.textContent = ''; // Geen foutmedling weergeven

    // Haal gekozen hoeveelheden op voor elk gerecht
    const aantallen = [
      document.getElementById('aantal_pasta').value,
      document.getElementById('aantal_pizza').value,
      document.getElementById('aantal_salade').value,
      document.getElementById('aantal_soep').value
    ];

    // Tel het totaal aantal gerechten op
    const totaalAantal = aantallen.reduce((sum, val) => sum + parseInt(val), 0);

    // Haal overige invoervelden op
    const kamernummer = document.getElementById('kamernummer').value.trim();
    const bezorgtijd = document.getElementById('bezorgtijd').value;
    const ampm = document.getElementById('ampm').value;

    // Controleer of iets niet is ingevuld of geen gerechten zijn gekozen
    if (totaalAantal === 0 || kamernummer === '' || bezorgtijd === '' || ampm === '') {
      e.preventDefault(); // Stop het versturen van het formulier
      foutmelding.textContent = 'Kies eerst een gerecht.'; // Laat foutmelding zien
    }
  });
});
