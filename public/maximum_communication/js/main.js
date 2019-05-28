/**
 * Monter le mot de passe du champ input de type password
 */
function showPassword() {
  let x = document.getElementById("password");
  let y = document.getElementById("show-password");
  if (x.type === "password") {
    x.type = "text";
    y.innerText = "";
    y.innerText = "Cacher";
  } else {
    x.type = "password";
    y.innerText = "";
    y.innerText = "Montrer";
  }
}