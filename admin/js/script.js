// Surgical Store - Basic JavaScript only.
function toggleMenu() {
    var nav = document.getElementById("mainNav");
    if (nav) nav.classList.toggle("open");
}
function addToCart() {
    alert("Product added to cart (frontend demo).");
}
function addWishlist(button) {
    var icon = button.querySelector("i");
    if (icon) {
        icon.classList.toggle("bi-heart-fill");
        icon.classList.toggle("bi-heart");
    }
}
function copyCoupon(code) {
    alert("Coupon Code: " + code);
}
function searchProducts() {
    var input = document.getElementById("productSearch");
    if (!input) return;
    var text = input.value.toLowerCase();
    document.querySelectorAll(".product-item").forEach(function(product) {
        product.style.display = product.innerText.toLowerCase().includes(text) ? "" : "none";
    }
    );
}
function filterCategory() {
    var filter = document.getElementById("categoryFilter");
    if (!filter) return;
    var value = filter.value.toLowerCase();
    document.querySelectorAll(".product-item").forEach(function(product) {
        var category = product.getAttribute("data-category");
        product.style.display = value === "" || category === value ? "" : "none";
    }
    );
}
function changeQuantity(button, amount) {
    var input = button.parentElement.querySelector(".qty-input");
    if (!input) return;
    var value = parseInt(input.value) || 1;
    value += amount;
    if (value < 1) value = 1;
    input.value = value;
}
function showFormMessage(event, message) {
    event.preventDefault();
    alert(message);
}
document.addEventListener("DOMContentLoaded", function() {
    var menuButton = document.querySelector(".menu-btn");
    if (menuButton) menuButton.addEventListener("click", toggleMenu);
    var adminMenu = document.querySelector(".menu-button");
    var adminSidebar = document.getElementById("sidebar");
    if (adminMenu && adminSidebar) {
        adminMenu.addEventListener("click", function() {
            adminSidebar.classList.toggle("open");
            adminSidebar.classList.toggle("show");
        }
        );
    }
    var tableSearch = document.getElementById("tableSearch");
    if (tableSearch) {
        tableSearch.addEventListener("keyup", function() {
            var table = document.getElementById("productTable");
            if (!table) return;
            var text = tableSearch.value.toLowerCase();
            table.querySelectorAll("tbody tr").forEach(function(row) {
                row.style.display = row.innerText.toLowerCase().includes(text) ? "" : "none";
            }
            );
        }
        );
    }
    document.querySelectorAll(".product-wishlist").forEach(function(button) {
        button.addEventListener("click", function() {
            addWishlist(button);
        }
        );
    }
    );
    document.querySelectorAll(".add-cart").forEach(function(button) {
        button.addEventListener("click", addToCart);
    }
    );
    document.querySelectorAll(".copy-coupon").forEach(function(button) {
        button.addEventListener("click", function() {
            copyCoupon(button.getAttribute("data-code"));
        }
        );
    }
    );
    document.querySelectorAll(".qty-plus").forEach(function(button) {
        button.addEventListener("click", function() {
            changeQuantity(button, 1);
        }
        );
    }
    );
    document.querySelectorAll(".qty-minus").forEach(function(button) {
        button.addEventListener("click", function() {
            changeQuantity(button, -1);
        }
        );
    }
    );
    var search = document.getElementById("productSearch");
    if (search) search.addEventListener("keyup", searchProducts);
    var category = document.getElementById("categoryFilter");
    if (category) category.addEventListener("change", filterCategory);
    var newsletter = document.querySelector(".newsletter-form");
    if (newsletter) newsletter.addEventListener("submit", function(event) {
        event.preventDefault();
        alert("Thank you for subscribing!");
        newsletter.reset();
    }
    );
    var demoOrder = document.getElementById("demoOrderButton");
    if (demoOrder) demoOrder.addEventListener("click", function() {
        alert("This is a static frontend demo. No order is stored.");
    }
    );
    document.querySelectorAll(".show-message-form").forEach(function(form) {
        form.addEventListener("submit", function(event) {
            showFormMessage(event, "Thank you! This is a frontend demo.");
            form.reset();
        }
        );
    }
    );
}
);
