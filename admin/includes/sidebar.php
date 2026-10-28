<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
<!-- Logo -->
<div class="sidebar-logo">
<div class="logo-icon">
<i class="bi bi-heart-pulse-fill">
</i>
</div>
<div class="logo-text">
<strong>
                Surgical
            </strong>
<span>
                Store
            </span>
</div>
</div>
<!-- Navigation -->
<nav class="sidebar-nav">
<p class="menu-title">
            MAIN MENU
        </p>
<a href="dashboard.php"
           class="sidebar-link
<?php
echo ($currentPage == 'dashboard.php') ? 'active' : '';
?>
">
<i class="bi bi-grid-1x2-fill">
</i>
<span>
    Dashboard
</span>
</a>
<a href="products.php"
           class="sidebar-link
<?php
echo ($currentPage == 'products.php') ? 'active' : '';
?>
">
<i class="bi bi-box-seam-fill">
</i>
<span>
    Products
</span>
</a>
<a href="categories.php"
           class="sidebar-link
<?php
echo ($currentPage == 'categories.php') ? 'active' : '';
?>
">
<i class="bi bi-tags-fill">
</i>
<span>
    Categories
</span>
</a>
<a href="orders.php"
           class="sidebar-link
<?php
echo ($currentPage == 'orders.php') ? 'active' : '';
?>
">
<i class="bi bi-cart-check-fill">
</i>
<span>
    Orders
</span>
</a>
<p class="menu-title">
    MANAGEMENT
</p>
<a href="customers.php"
           class="sidebar-link
<?php
echo ($currentPage == 'customers.php') ? 'active' : '';
?>
">
<i class="bi bi-people-fill">
</i>
<span>
    Customers
</span>
</a>
<a href="suppliers.php"
           class="sidebar-link
<?php
echo ($currentPage == 'suppliers.php') ? 'active' : '';
?>
">
<i class="bi bi-truck">
</i>
<span>
    Suppliers
</span>
</a>
<a href="inventory.php"
           class="sidebar-link
<?php
echo ($currentPage == 'inventory.php') ? 'active' : '';
?>
">
<i class="bi bi-boxes">
</i>
<span>
    Inventory
</span>
</a>
<p class="menu-title">
    REPORTS
</p>
<a href="sales-report.php"
           class="sidebar-link
<?php
echo ($currentPage == 'sales-report.php') ? 'active' : '';
?>
">
<i class="bi bi-graph-up-arrow">
</i>
<span>
    Sales Report
</span>
</a>
<a href="stock-report.php"
           class="sidebar-link
<?php
echo ($currentPage == 'stock-report.php') ? 'active' : '';
?>
">
<i class="bi bi-clipboard-data">
</i>
<span>
    Stock Report
</span>
</a>
<p class="menu-title">
    SYSTEM
</p>
<a href="settings.php"
           class="sidebar-link
<?php
echo ($currentPage == 'settings.php') ? 'active' : '';
?>
">
<i class="bi bi-gear-fill">
</i>
<span>
    Settings
</span>
</a>
<a href="profile.php"
           class="sidebar-link
<?php
echo ($currentPage == 'profile.php') ? 'active' : '';
?>
">
<i class="bi bi-person-circle">
</i>
<span>
    Profile
</span>
</a>
<a href="logout.php" class="sidebar-link logout-link">
<i class="bi bi-box-arrow-right">
</i>
<span>
        Logout
    </span>
</a>
</nav>
</aside>
