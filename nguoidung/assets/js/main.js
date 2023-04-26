/*price range*/

$("#sl2").slider();

var RGBChange = function () {
  $("#RGB").css(
    "background",
    "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
  );
};

/*scroll to top*/

$(document).ready(function () {
  $(function () {
    $.scrollUp({
      scrollName: "scrollUp", // Element ID
      scrollDistance: 300, // Distance from top/bottom before showing element (px)
      scrollFrom: "top", // 'top' or 'bottom'
      scrollSpeed: 300, // Speed back to top (ms)
      easingType: "linear", // Scroll to top easing (see http://easings.net/)
      animation: "fade", // Fade, slide, none
      animationSpeed: 200, // Animation in speed (ms)
      scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
      //scrollTarget: false, // Set a custom target element for scrolling to the top
      scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
      scrollTitle: false, // Set a custom <a> title if required.
      scrollImg: false, // Set true to use image
      activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
      zIndex: 2147483647, // Z-Index for the overlay
    });
  });
});

/* Rating star */

var stars = document.querySelectorAll("#star");
var input_rate = document.getElementById("rate");
var input_submit_comment = document.getElementById("submit-comment");
var ktraStar = false;
// Duyệt qua tất cả các thẻ i
for (var i = 0; i < stars.length; i++) {
  // thêm sự kiện hover
  stars[i].addEventListener("mouseover", function () {
    ktraStar = false;
    input_submit_comment.type = "hidden";
    input_rate.value = 0;
    // Lấy vị trí của thẻ i được hover
    var index = Array.from(stars).indexOf(this);
    // Thay đổi class của thẻ i được hover và các thẻ i trước đó
    for (var j = 0; j <= index; j++) {
      stars[j].classList.remove("fa-star-o");
      stars[j].classList.add("fa-star");
    }
    // Thay đổi class của các thẻ i sau đó
    for (var k = index + 1; k < stars.length; k++) {
      stars[k].classList.remove("fa-star");
      stars[k].classList.add("fa-star-o");
    }
  });

  // Thêm sự kiện hover để trở lại class ban đầu
  stars[i].addEventListener("mouseout", function () {
    if (ktraStar == false) {
      // Xóa tất cả các class fa-star và thêm lại class ban đầu fa-star-o
      for (var j = 0; j < stars.length; j++) {
        stars[j].classList.remove("fa-star");
        stars[j].classList.add("fa-star-o");
      }
    }
  });

  // thêm sự kiện click
  stars[i].addEventListener("click", function () {
    ktraStar = true;
    input_submit_comment.type = "submit";
    var index = Array.from(stars).indexOf(this);
    input_rate.value = index + 1;
  });
}

// show password

function showPass(input, show) {
  var input = document.getElementById(input);
  var show = document.getElementById(show);
  if (input.type === "password") {
    input.type = "text";
    show.className = "fa fa-eye";
  } else {
    input.type = "password";
    show.className = "fa fa-eye-slash";
  }
}

// Cập nhật số lượng khi tăng giảm ở form chi tiết sản phẩm
function updateHref(id) {
  // Lấy giá trị số lượng từ input
  var quantity = document.getElementById("quantity_order_detail").value;

  // Cập nhật giá trị vào href của thẻ a
  var buyLink = document.getElementById("buyLink");
  buyLink.href =
    "index.php?page_layout=ThemVaoGioHang&id=" + id + "&sl=" + quantity;
}
