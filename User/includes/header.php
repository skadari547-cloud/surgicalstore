<?php
$pageTitle = $pageTitle ?? 'Surgical Store';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
<?=
htmlspecialchars($pageTitle)
?>
| Surgical Store
</title>
<!-- Bootstrap -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
<!-- Bootstrap Icons -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="/SurgicalStore/css/style.css">
</head>
<body>
<!-- Top Bar -->
<div class="top-bar">
<div class="container d-flex justify-content-between">
<span>
<i class="bi bi-truck">
</i>
                Free Delivery on orders above ₹999
            </span>
<span>
<i class="bi bi-telephone">
</i>
                Support: +91 98765 43210
            </span>
</div>
</div>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
<div class="container">
<a class="navbar-brand fw-bold" href="index.php">
<i class="bi bi-heart-pulse-fill brand-icon">
</i>
<span>
                    Surgical
                    <span class="brand-dark">
                        Store
                    </span>
</span>
</a>
<button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNavbar">
<span class="navbar-toggler-icon">
</span>
</button>
<div class="collapse navbar-collapse" id="mainNavbar">
<ul class="navbar-nav mx-auto">
<li class="nav-item">
<a class="nav-link" href="index.php">
                            Home
                        </a>
</li>
<li class="nav-item">
<a class="nav-link" href="categories.php">
                            Categories
                        </a>
</li>
<li class="nav-item">
<a class="nav-link" href="products.php">
                            Products
                        </a>
</li>
<li class="nav-item">
<a class="nav-link" href="orders.php">
                            My Orders
                        </a>
</li>
</ul>
<div class="navbar-actions">
<a href="wishlist.php" class="nav-icon">
<i class="bi bi-heart">
</i>
<span class="badge-count">
                            2
                        </span>
</a>
<a href="cart.php" class="nav-icon">
<i class="bi bi-cart3">
</i>
<span class="badge-count">
                            3
                        </span>
</a>
<a href="login.php" class="btn btn-primary-custom ms-2">
<i class="bi bi-person">
</i>
                        Login
                    </a>
</div>
</div>
</div>
</nav>
