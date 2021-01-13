// Using JQuery to fetch items
let output = ""

$("body").addClass("loading");

// Immediately invoked function expression IIFE
(function () {
  $.getJSON('fetch_products.php', {
    format: "json"
  })
    .done(function (data) {
      $.each(data, function (key, value) {
        $("body").removeClass("loading");
    // console.log(value)
    // destructuring
    const { product_id, product_name, product_desc, product_img, price, quantity} = value
    output += `
    <div class="item_card">
      <div class="item_img">
        <img src="./uploads/${product_img}" alt="${product_name}">
      </div>
      <div class="item_desc">
        <p class="item_title">${product_name}</p>
        <p class="item_detail">${product_desc}</p>
        <p class="item_price">RM${price}</p>
        <form method="POST" action="add_to_cart.php">
        <input type="hidden" name="id" value="${product_id}">
        <input type="hidden" name="name" value="${product_name}">
        <input type="hidden" name="price" value="${price}">
        <input type="hidden" name="image" value="${product_img}">
        <input type="hidden" name="instock" value="${quantity}">
        <input type="submit" value="Add to Cart" name="add" class="btn-cart">
        </form>
      </div>
    </div>
    `
      })
      $(".items_container").html(output);
    })
    .fail(function (err) {
      console.log(err)
    })
})()

// Using vanilla javascript ES-6 fetch

// document.addEventListener("DOMContentLoaded", () => {
//   fetch("fetch_products.php")
//     .then(res => {
//     return res.json()
//     }).then(data => {
//     console.log(data)
//   }).catch(err =>console.log(err))
//     })
