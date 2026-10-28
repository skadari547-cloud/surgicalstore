# SurgicalStore - Project Structure

## Main folders

- `index.php` - Guest home page
- `products.php` - Guest product listing
- `product_details.php` - Guest single product page
- `categories.php` - Guest categories
- `offers.php` - Guest offers
- `services.php` - Guest delivery services
- `about.php` - Guest about page
- `contact.php` - Guest contact page
- `login.php` / `register.php` - Guest authentication entry pages

### `includes/`
Common database, header, navbar and footer files used by guest pages.

### `css/`
Main guest/user stylesheet.

### `js/`
Main guest/user JavaScript and validation JavaScript.

### `admin/`
Admin dashboard and CRUD pages.
- `css/style.css` - Admin styling
- `js/script.js` - Admin interactions
- `js/validation.js` - Admin form validation
- `includes/` - Admin header, navbar, sidebar and footer
- Product/category/coupon/supplier/service/customer/order management pages

### `User/`
Logged-in customer area.
- `includes/` - User authentication/layout/header/footer
- `config/` - User database configuration
- Product browsing, cart, checkout, orders, wishlist, reviews, profile and services

### `images/` and `assets/images/`
Product and site images. Existing image filenames are preserved so database image values continue to work.

## Database

Keep the database name as `surgicalstore`. Do not rename the tables or image filenames unless the PHP/database references are changed together.

## Important

Existing validation files are retained. The project is organized into separate PHP, CSS and JS files rather than putting the whole page into one long line.
