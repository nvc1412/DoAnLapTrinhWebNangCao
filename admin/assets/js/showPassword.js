function showPass(input, show) {
  var input = document.getElementById(input);
  var show = document.getElementById(show);
  if (input.type === "password") {
    input.type = "text";
    show.className = "fas fas fa-eye";
  } else {
    input.type = "password";
    show.className = "fas fas fa-eye-slash";
  }
}
