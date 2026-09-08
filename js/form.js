(function () {
  "use strict";

  var form = document.getElementById("anfrage-form");
  if (!form) return;

  var statusEl = document.getElementById("form-status");

  function setError(field, message) {
    var wrap = field.closest(".form-field");
    if (!wrap) return;
    var errorEl = wrap.querySelector(".form-field__error");
    if (message) {
      wrap.classList.add("has-error");
      if (errorEl) errorEl.textContent = message;
      field.setAttribute("aria-invalid", "true");
    } else {
      wrap.classList.remove("has-error");
      if (errorEl) errorEl.textContent = "";
      field.removeAttribute("aria-invalid");
    }
  }

  function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  }

  function validateField(field) {
    if (!field.hasAttribute("required") && field.type !== "email") return true;

    var value = field.value.trim();

    if (field.hasAttribute("required") && !value) {
      setError(field, "Bitte füllen Sie dieses Feld aus.");
      return false;
    }

    if (field.type === "email" && value && !isValidEmail(value)) {
      setError(field, "Bitte geben Sie eine gültige E-Mail-Adresse ein.");
      return false;
    }

    setError(field, "");
    return true;
  }

  form.querySelectorAll("input, textarea, select").forEach(function (field) {
    field.addEventListener("blur", function () {
      validateField(field);
    });
  });

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    statusEl.className = "form-status";
    statusEl.textContent = "";

    var fields = form.querySelectorAll("input, textarea, select");
    var valid = true;
    var firstInvalid = null;

    fields.forEach(function (field) {
      if (!validateField(field)) {
        valid = false;
        if (!firstInvalid) firstInvalid = field;
      }
    });

    if (!valid) {
      statusEl.classList.add("is-error");
      statusEl.textContent = "Bitte überprüfen Sie Ihre Angaben und füllen Sie alle Pflichtfelder korrekt aus.";
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    var submitBtn = form.querySelector("button[type='submit']");
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = "Wird gesendet …";
    }

    fetch(form.action, {
      method: "POST",
      body: new FormData(form),
      headers: { "X-Requested-With": "XMLHttpRequest" }
    })
      .then(function (response) {
        if (!response.ok) throw new Error("Serverfehler");
        return response.json().catch(function () {
          return { success: true };
        });
      })
      .then(function (data) {
        if (data && data.success === false) throw new Error(data.message || "Fehler");
        statusEl.classList.add("is-success");
        statusEl.textContent =
          "Vielen Dank für Ihre Anfrage! Wir melden uns so bald wie möglich bei Ihnen.";
        form.reset();
      })
      .catch(function () {
        statusEl.classList.add("is-error");
        statusEl.textContent =
          "Leider ist beim Senden ein Fehler aufgetreten. Bitte versuchen Sie es erneut oder schreiben Sie uns direkt per E-Mail.";
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = "Anfrage senden";
        }
      });
  });
})();
