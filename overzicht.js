document.addEventListener("DOMContentLoaded", () => {
  const bestellingStr = localStorage.getItem("laatsteBestelling");

  if (!bestellingStr) {
    alert("Geen bestelling gevonden.");
    return;
  }

  const bestelling = JSON.parse(bestellingStr);

  const tbody = document.querySelector(".bestelling-overzicht tbody");
  tbody.innerHTML = "";

  let totaalPrijs = 0;

  bestelling.gerechten.forEach((gerecht) => {
    const tr = document.createElement("tr");

    const tdNaam = document.createElement("td");
    tdNaam.textContent = gerecht.naam;
    tr.appendChild(tdNaam);

    const tdAantal = document.createElement("td");
    tdAantal.textContent = gerecht.aantal;
    tr.appendChild(tdAantal);

    const tdPrijsStuk = document.createElement("td");
    tdPrijsStuk.textContent = `€${gerecht.prijs.toFixed(2)}`;
    tr.appendChild(tdPrijsStuk);

    const totaalGerecht = gerecht.prijs * gerecht.aantal;
    totaalPrijs += totaalGerecht;

    const tdTotaal = document.createElement("td");
    tdTotaal.textContent = `€${totaalGerecht.toFixed(2)}`;
    tr.appendChild(tdTotaal);

    tbody.appendChild(tr);
  });

  const trTotaalExcl = document.createElement("tr");
  trTotaalExcl.innerHTML = `
    <td colspan="3" style="text-align:right; font-weight:bold;">Totaal excl. BTW:</td>
    <td style="font-weight:bold;">€${totaalPrijs.toFixed(2)}</td>
  `;
  tbody.appendChild(trTotaalExcl);

  const btw = totaalPrijs * 0.21;

  const trBtw = document.createElement("tr");
  trBtw.innerHTML = `
    <td colspan="3" style="text-align:right; font-weight:bold;">21% BTW:</td>
    <td>€${btw.toFixed(2)}</td>
  `;
  tbody.appendChild(trBtw);

  const totaalIncl = totaalPrijs + btw;

  const trTotaalIncl = document.createElement("tr");
  trTotaalIncl.innerHTML = `
    <td colspan="3" style="text-align:right; font-weight:bold;">Totaal incl. BTW:</td>
    <td style="font-weight:bold;">€${totaalIncl.toFixed(2)}</td>
  `;
  tbody.appendChild(trTotaalIncl);

  const trKamer = document.createElement("tr");
  trKamer.innerHTML = `
    <td colspan="3" style="text-align:right; font-weight:bold;">Kamernummer:</td>
    <td>${bestelling.kamernummer}</td>
  `;
  tbody.appendChild(trKamer);

  const trTijd = document.createElement("tr");
  trTijd.innerHTML = `
    <td colspan="3" style="text-align:right; font-weight:bold;">Bezorgtijd:</td>
    <td>${bestelling.bezorgtijd}</td>
  `;
  tbody.appendChild(trTijd);
});
