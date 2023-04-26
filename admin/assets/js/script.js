$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

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

function priceFormat(n) {
  return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " VNĐ";
}
