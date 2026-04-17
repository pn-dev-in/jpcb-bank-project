<script>
(() => {
  const principalInput = document.getElementById('emi-principal');
  const rateInput = document.getElementById('emi-rate');
  const tenureInput = document.getElementById('emi-tenure');
  const resetButton = document.getElementById('emi-reset');
  const scheduleBody = document.getElementById('emi-schedule-body');

  if (!principalInput || !rateInput || !tenureInput || !scheduleBody) {
    return;
  }

  const fmt = (value) => '₹' + Math.round(value).toLocaleString('en-IN');

  const principalDisplay = document.getElementById('emi-principal-display');
  const rateDisplay = document.getElementById('emi-rate-display');
  const tenureDisplay = document.getElementById('emi-tenure-display');
  const yearsDisplay = document.getElementById('emi-years-display');
  const emiMonthly = document.getElementById('emi-monthly-value');
  const emiInterest = document.getElementById('emi-interest-value');
  const emiTotal = document.getElementById('emi-total-value');
  const principalSummary = document.getElementById('emi-principal-summary');
  const interestSummary = document.getElementById('emi-interest-summary');
  const principalBar = document.getElementById('emi-principal-bar');
  const interestBar = document.getElementById('emi-interest-bar');

  const render = () => {
    const principal = Number(principalInput.value);
    const rate = Number(rateInput.value);
    const tenure = Number(tenureInput.value);
    const monthlyRate = rate / 12 / 100;

    let emi = principal / Math.max(tenure, 1);
    if (monthlyRate > 0) {
      const factor = Math.pow(1 + monthlyRate, tenure);
      emi = (principal * monthlyRate * factor) / (factor - 1);
    }

    const totalPayable = emi * tenure;
    const totalInterest = totalPayable - principal;

    principalDisplay.textContent = fmt(principal);
    rateDisplay.textContent = rate.toFixed(rate % 1 === 0 ? 0 : 2) + '%';
    tenureDisplay.textContent = tenure + ' months';
    yearsDisplay.textContent = (tenure / 12).toFixed(1);
    emiMonthly.textContent = fmt(emi);
    emiInterest.textContent = fmt(totalInterest);
    emiTotal.textContent = fmt(totalPayable);
    principalSummary.textContent = fmt(principal);
    interestSummary.textContent = fmt(totalInterest);

    const principalWidth = totalPayable > 0 ? (principal / totalPayable) * 100 : 0;
    principalBar.style.width = principalWidth + '%';
    interestBar.style.width = (100 - principalWidth) + '%';

    let balance = principal;
    const rows = [];
    for (let month = 1; month <= tenure; month += 1) {
      const interestPart = balance * monthlyRate;
      const principalPart = emi - interestPart;
      balance = Math.max(0, balance - principalPart);

      rows.push(
        '<tr class="border-b" style="border-color: hsl(var(--border));">' +
          '<td class="p-3 text-foreground">' + month + '</td>' +
          '<td class="p-3 text-right text-foreground">' + fmt(emi) + '</td>' +
          '<td class="p-3 text-right text-foreground">' + fmt(principalPart) + '</td>' +
          '<td class="p-3 text-right" style="color: hsl(var(--muted-foreground));">' + fmt(interestPart) + '</td>' +
          '<td class="p-3 text-right text-foreground">' + fmt(balance) + '</td>' +
        '</tr>'
      );
    }

    scheduleBody.innerHTML = rows.join('');
  };

  [principalInput, rateInput, tenureInput].forEach((input) => {
    input.addEventListener('input', render);
  });

  if (resetButton) {
    resetButton.addEventListener('click', () => {
      principalInput.value = '500000';
      rateInput.value = '10';
      tenureInput.value = '36';
      render();
    });
  }

  render();
})();
</script>
