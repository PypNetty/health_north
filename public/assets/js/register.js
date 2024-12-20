// Validation côté client du mot de passe
const form = document.getElementById("registerForm");
const password = document.getElementById("password");
const passwordConfirm = document.getElementById("password_confirm");
const secuInput = document.getElementById("secu");

// Formatage automatique pendant la saisie du numéro de sécu
secuInput.addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, ""); // Garde uniquement les chiffres
  if (value.length > 15) value = value.slice(0, 15);

  // Formatage avec espaces
  const formattedValue = value.replace(/(\d)(?=(\d{2})+(?!\d))/g, "$1 ").trim();
  e.target.value = formattedValue;
});

// Validation du formulaire
form.addEventListener("submit", function (e) {
  // Validation du mot de passe
  if (password.value !== passwordConfirm.value) {
    e.preventDefault();
    alert("Les mots de passe ne correspondent pas");
    passwordConfirm.focus();
    return;
  }

  // Validation du numéro de sécu
  const secu = secuInput.value.replace(/\s/g, "");

  if (secu.length !== 15) {
    e.preventDefault();
    alert("Le numéro de sécurité sociale doit contenir 15 chiffres");
    secuInput.focus();
    return;
  }

  if (!/^\d+$/.test(secu)) {
    e.preventDefault();
    alert("Le numéro de sécurité sociale ne doit contenir que des chiffres");
    secuInput.focus();
    return;
  }

  if (!["1", "2"].includes(secu[0])) {
    e.preventDefault();
    alert("Le numéro de sécurité sociale doit commencer par 1 ou 2");
    secuInput.focus();
    return;
  }
});
