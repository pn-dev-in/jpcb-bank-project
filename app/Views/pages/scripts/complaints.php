<script>
(() => {
  const root = document.getElementById('complaint-wizard');
  if (!root) {
    return;
  }

  const panels = Array.from(root.querySelectorAll('[data-complaint-panel]'));
  const indicators = Array.from(root.querySelectorAll('[data-complaint-indicator]'));
  const connectors = Array.from(root.querySelectorAll('[data-complaint-connector]'));
  const reference = document.getElementById('complaint-reference');

  const setStep = (step) => {
    root.dataset.currentStep = String(step);

    panels.forEach((panel) => {
      panel.classList.toggle('hidden', Number(panel.dataset.complaintPanel) !== step);
    });

    indicators.forEach((indicator) => {
      const value = Number(indicator.dataset.complaintIndicator);
      const active = value <= step;
      indicator.classList.toggle('bg-primary', active);
      indicator.classList.toggle('text-primary-foreground', active);
      indicator.classList.toggle('bg-muted', !active);
      indicator.style.color = active ? '' : 'hsl(var(--muted-foreground))';
    });

    connectors.forEach((connector) => {
      const value = Number(connector.dataset.complaintConnector);
      connector.classList.toggle('bg-primary', step > value);
      connector.classList.toggle('bg-muted', step <= value);
    });
  };

  const validateStep = (step) => {
    const fields = Array.from(root.querySelectorAll('[data-complaint-required-step="' + step + '"]'));
    for (const field of fields) {
      if (!field.value || !String(field.value).trim()) {
        field.focus();
        if (typeof field.reportValidity === 'function') {
          field.reportValidity();
        }
        return false;
      }
    }
    return true;
  };

  root.querySelectorAll('[data-complaint-next]').forEach((button) => {
    button.addEventListener('click', () => {
      const currentStep = Number(root.dataset.currentStep || '1');
      if (!validateStep(currentStep)) {
        return;
      }
      setStep(Number(button.dataset.complaintNext));
    });
  });

  root.querySelectorAll('[data-complaint-prev]').forEach((button) => {
    button.addEventListener('click', () => {
      setStep(Number(button.dataset.complaintPrev));
    });
  });

  const submitButton = document.getElementById('complaint-submit');
  if (submitButton) {
    submitButton.addEventListener('click', () => {
      if (!validateStep(2)) {
        return;
      }

      const now = new Date();
      const yyyy = now.getFullYear();
      const mm = String(now.getMonth() + 1).padStart(2, '0');
      const dd = String(now.getDate()).padStart(2, '0');
      const serial = String(Math.floor(Math.random() * 9000) + 1000);

      if (reference) {
        reference.textContent = 'JPCB-' + yyyy + mm + dd + '-' + serial;
      }

      setStep(3);
    });
  }

  setStep(1);
})();
</script>
