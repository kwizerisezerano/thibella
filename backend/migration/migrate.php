<?php

/**
 * Thibella – Additive Migration Runner
 * -------------------------------------
 * - NEVER drops the database.
 * - Tracks every migration in `_migrations` table.
 * - Only runs migrations that haven't been executed yet.
 * - To add a new migration: append a new run_migration() call at the bottom.
 */

require_once __DIR__ . '/../core/Env.php';
require_once __DIR__ . '/../core/helpers.php';
loadEnv(__DIR__ . '/../.env');

$host     = env('DB_HOST', 'localhost');
$user     = env('DB_USER', 'root');
$password = env('DB_PASSWORD', '');
$database = env('DB_NAME', 'thibella_db');

// ── Connect (create DB if missing) ───────────────────────────────────────────
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$conn->query("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
$conn->select_db($database);
$conn->set_charset('utf8mb4');
$conn->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");

echo "=== Thibella Migration Runner ===\n\n";

// ── Bootstrap _migrations tracker ────────────────────────────────────────────
$conn->query("
    CREATE TABLE IF NOT EXISTS `_migrations` (
        `id`     int(11)      NOT NULL AUTO_INCREMENT,
        `name`   varchar(200) NOT NULL,
        `ran_at` timestamp    NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `name` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

function already_ran(mysqli $conn, string $name): bool
{
    $stmt = $conn->prepare("SELECT id FROM `_migrations` WHERE name = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->store_result();
    $found = $stmt->num_rows > 0;
    $stmt->close();
    return $found;
}

function mark_ran(mysqli $conn, string $name): void
{
    $stmt = $conn->prepare("INSERT INTO `_migrations` (name) VALUES (?)");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->close();
}

function run_migration(mysqli $conn, string $name, callable $fn): void
{
    if (already_ran($conn, $name)) {
        echo "  – skipped  : $name\n";
        return;
    }
    $fn($conn);
    mark_ran($conn, $name);
    echo "  ✔ ran      : $name\n";
}

// ── Migrations ────────────────────────────────────────────────────────────────

run_migration($conn, '001_create_categories', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `categories` (
            `id`          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `title`       varchar(100)     NOT NULL,
            `description` text             DEFAULT NULL,
            `slug`        varchar(120)     NOT NULL,
            `image`       varchar(255)     DEFAULT NULL,
            `created_at`  timestamp        NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '002_create_subcategories', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `subcategories` (
            `id`          int(11)          NOT NULL AUTO_INCREMENT,
            `name`        varchar(100)     NOT NULL,
            `category_id` int(10) UNSIGNED NOT NULL,
            `slug`        varchar(255)     NOT NULL,
            `image`       varchar(500)     DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `slug` (`slug`),
            KEY `category_id` (`category_id`),
            CONSTRAINT `subcategories_ibfk_1`
                FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '003_create_users', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `users` (
            `id`         int(11)              NOT NULL AUTO_INCREMENT,
            `name`       varchar(500)         DEFAULT NULL,
            `email`      varchar(500)         DEFAULT NULL,
            `phone`      varchar(500)         DEFAULT NULL,
            `password`   varchar(255)         DEFAULT NULL,
            `role`       enum('admin','user') DEFAULT 'user',
            `created_at` timestamp            NOT NULL DEFAULT current_timestamp(),
            `email_hash` varchar(64)          DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email_hash` (`email_hash`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '004_create_products', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `products` (
            `id`                 int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `productName`        varchar(255)     NOT NULL,
            `description`        text             NOT NULL,
            `priceCents`         int(11)          NOT NULL DEFAULT 0,
            `stock`              int(11)          NOT NULL DEFAULT 0,
            `size`               varchar(50)      DEFAULT NULL,
            `color`              varchar(50)      DEFAULT NULL,
            `type`               varchar(100)     DEFAULT NULL,
            `isOnSale`           tinyint(1)       DEFAULT 0,
            `brand`              varchar(100)     DEFAULT NULL,
            `subCategory_id`     int(11)          DEFAULT NULL,
            `category_id`        int(10) UNSIGNED DEFAULT NULL,
            `imageUrl`           varchar(500)     DEFAULT NULL,
            `possibleImagesUrls` longtext         CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
                                 CHECK (json_valid(`possibleImagesUrls`)),
            `createdAt`          timestamp        NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `fk_products_category` (`category_id`),
            KEY `fk_products_subcategory` (`subCategory_id`),
            CONSTRAINT `fk_products_category`
                FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
            CONSTRAINT `fk_products_subcategory`
                FOREIGN KEY (`subCategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '005_create_orders', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `orders` (
            `id`                  int(11)      NOT NULL AUTO_INCREMENT,
            `user_id`             int(11) UNSIGNED NOT NULL,
            `full_name`           varchar(100) DEFAULT NULL,
            `phone_number`        varchar(30)  DEFAULT NULL,
            `email`               varchar(100) DEFAULT NULL,
            `country`             varchar(50)  DEFAULT NULL,
            `province`            varchar(50)  DEFAULT NULL,
            `district`            varchar(50)  DEFAULT NULL,
            `sector`              varchar(50)  DEFAULT NULL,
            `nearby_landmark`     varchar(255) DEFAULT NULL,
            `payment_method`      varchar(50)  DEFAULT NULL,
            `mobile_money_number` varchar(30)  DEFAULT NULL,
            `orderTotalAmount`    int(15)      DEFAULT NULL,
            `status`              varchar(20)  NOT NULL DEFAULT 'pending',
            `created_at`          timestamp    NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `fk_orders_user` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '006_create_order_items', function (mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS `order_items` (
            `id`                 int(11)          NOT NULL AUTO_INCREMENT,
            `order_id`           int(11)          NOT NULL,
            `product_id`         int(10) UNSIGNED DEFAULT NULL,
            `product_name`       varchar(150)     NOT NULL,
            `price_cents`        int(11)          NOT NULL,
            `quantity`           int(11)          NOT NULL DEFAULT 1,
            `selected_color`     varchar(50)      DEFAULT NULL,
            `selected_size`      varchar(50)      DEFAULT NULL,
            `image_url`          text             DEFAULT NULL,
            `productTotalAmount` int(15)          NOT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_order_items_order` (`order_id`),
            KEY `fk_order_items_product` (`product_id`),
            CONSTRAINT `fk_order_items_order`
                FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_order_items_product`
                FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
});

run_migration($conn, '007_seed_categories', function (mysqli $conn) {
    $categories = [
        ['Clothes',          'Fashion clothing including shirts, hoodies and trousers',   'clothing',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603874/clothes_gyujfw.jpg'],
        ['Shoes',            'All types of shoes including sport shoes and casual shoes', 'shoes',           'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603948/shoes_h3vkax.jpg'],
        ['Electronics',      'Electronic devices like watches, headphones and gadgets',   'electronics',     'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603873/download_z7ztb3.jpg'],
        ['Kitchen & Dining', 'Kitchen essentials, cookware, utensils and dining sets',    'kitchen--dining', 'https://res.cloudinary.com/dck2vzccq/image/upload/v1777521430/kitchenware_z6ijnc.webp'],
        ['Cars',             'New and used cars, SUVs, trucks and vehicle accessories',   'cars',            'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603873/cars_onrliw.jpg'],
        ['Drinkware',        'Bottles, cups, tumblers and drinkware for every lifestyle', 'drinkware',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1777463279/IMG-20260429-WA0020_aqvkmr.jpg'],
    ];

    $stmt = $conn->prepare("INSERT IGNORE INTO `categories` (title, description, slug, image) VALUES (?, ?, ?, ?)");
    foreach ($categories as $cat) {
        $stmt->bind_param('ssss', $cat[0], $cat[1], $cat[2], $cat[3]);
        $stmt->execute();
    }
    $stmt->close();
});

run_migration($conn, '008_seed_subcategories', function (mysqli $conn) {
    $subcategories = [
        // CLOTHES
        ['clothing', 'Clothes (Men)',           'men',                   'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415860/men_clothes_hcmu9u.jpg'],
        ['clothing', 'Clothes (Women)',         'clothes-women',         'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415861/women_clothes_ngdhdo.jpg'],
        ['clothing', 'Kids (Clothes)',          'kids-clothes',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415861/kids_subcategory_kuwaty.jpg'],
        ['clothing', 'T-Shirts',                't-shirts',              null],
        ['clothing', 'Hoodies & Sweatshirts',   'hoodies-sweatshirts',   null],
        ['clothing', 'Shirts & Blouses',        'shirts-blouses',        null],
        ['clothing', 'Jeans',                   'jeans',                 'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602868/a8a7ab0988be437fb5fe2a63148cbda1_tssx6v.jpg'],
        ['clothing', 'Trousers & Chinos',       'trousers-chinos',       null],
        ['clothing', 'Dresses',                 'dresses',               'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602811/26ae817f15784160acdd80663d374bd3_fqewaf.jpg'],
        ['clothing', 'Skirts',                  'skirts',                null],
        ['clothing', 'Jackets & Coats',         'jackets-coats',         null],
        ['clothing', 'Suits & Blazers',         'suits-blazers',         null],
        ['clothing', 'Shorts',                  'shorts',                null],
        ['clothing', 'Activewear & Sportswear', 'activewear-sportswear', null],
        ['clothing', 'Underwear & Lingerie',    'underwear-lingerie',    null],
        ['clothing', 'Socks',                   'socks',                 'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602809/44019494b0414f23a4d5d04ea16d8f88_s9nmqi.jpg'],
        ['clothing', 'Pyjamas & Loungewear',    'pyjamas-loungewear',    null],
        ['clothing', 'Abayas & Modest Wear',    'abayas-modest-wear',    null],
        ['clothing', 'School Uniforms',         'school-uniforms',       null],
        ['clothing', 'Traditional & Cultural',  'traditional-cultural',  null],
        // SHOES
        ['shoes', 'For Everyone (Shoes)', 'for-everyone-shoes', 'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603948/shoes_h3vkax.jpg'],
        ['shoes', "Men's Shoes",          'mens-shoes',         'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602804/7ceb70ac71d24e8ebde7de078415317b_ibome1.jpg'],
        ['shoes', "Women's Shoes",        'womens-shoes',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602852/19af757cd13f4396851a5cedd3fe46f2_ak46tc.jpg'],
        ['shoes', "Kids' Shoes",          'kids-shoes',         null],
        ['shoes', 'Sneakers',             'sneakers',           'https://res.cloudinary.com/dck2vzccq/image/upload/v1777284925/4a23a8d5ceeb4e58bb63bc20f6b5f865_odkc6g.jpg'],
        ['shoes', 'Running Shoes',        'running-shoes',      'https://res.cloudinary.com/dck2vzccq/image/upload/v1777284927/d3c4ff57ef51487a82246377016bb5a8_sn8a0r.jpg'],
        ['shoes', 'Sport Shoes',          'sport-shoes',        null],
        ['shoes', 'Casual Shoes',         'casual-shoes',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602790/fcc7baf0bd154401a41c685634c2d6cf_lixekr.jpg'],
        ['shoes', 'Formal Shoes',         'formal-shoes',       null],
        ['shoes', 'Boots',                'boots',              null],
        ['shoes', 'Sandals & Flip Flops', 'sandals-flip-flops', null],
        ['shoes', 'Heels',                'heels',              null],
        ['shoes', 'Loafers & Slip-Ons',   'loafers-slip-ons',   null],
        // ELECTRONICS
        ['electronics', 'Mobile Devices',        'mobile-devices',      'https://res.cloudinary.com/dck2vzccq/image/upload/v1780418006/Mobile_Devices_gzp2ph.jpg'],
        ['electronics', 'Smartphone',            'smartphone',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1780562661/smartphoneSubcategory_bmyblm.jpg'],
        ['electronics', 'Keypad Phone',          'keypad-phone',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1780563156/key_pad_phone_btydem.jpg'],
        ['electronics', 'Tablets',               'tablets',             null],
        ['electronics', 'Laptops',               'laptops',             null],
        ['electronics', 'Desktop Computers',     'desktop-computers',   null],
        ['electronics', 'Smartwatches',          'smartwatches',        null],
        ['electronics', 'Watches',               'watches',             'https://res.cloudinary.com/dck2vzccq/image/upload/v1780574815/watches_ecrcpu.jpg'],
        ['electronics', 'Headphones & Earbuds',  'headphones-earbuds',  null],
        ['electronics', 'Bluetooth Speakers',    'bluetooth-speakers',  null],
        ['electronics', 'TV & Monitors',         'tv-monitors',         null],
        ['electronics', 'Cameras & Photography', 'cameras-photography', null],
        ['electronics', 'Phone Accessories',     'phone-accessories',   'https://res.cloudinary.com/dck2vzccq/image/upload/v1777384133/2efd16286dfb4442ac1c9c7806dfaabf_eh8wqh.jpg'],
        ['electronics', 'Chargers & Cables',     'chargers-cables',     null],
        ['electronics', 'Power Banks',           'power-banks',         null],
        ['electronics', 'Radio',                 'radio',               'https://res.cloudinary.com/dck2vzccq/image/upload/v1780574668/radion_wpneni.webp'],
        ['electronics', 'Home Appliances',       'home-appliances',     null],
        ['electronics', 'Gaming',                'gaming',              null],
        ['electronics', 'Printers & Scanners',   'printers-scanners',   null],
        // KITCHEN
        ['kitchen--dining', 'Cookware',               'cookware',             null],
        ['kitchen--dining', 'Bakeware',               'bakeware',             null],
        ['kitchen--dining', 'Kitchen Knives & Tools', 'kitchen-knives-tools', null],
        ['kitchen--dining', 'Pots & Pans',            'pots-pans',            null],
        ['kitchen--dining', 'Plates & Bowls',         'plates-bowls',         null],
        ['kitchen--dining', 'Cups & Mugs',            'cups-mugs',            null],
        ['kitchen--dining', 'Cutlery & Utensils',     'cutlery-utensils',     null],
        ['kitchen--dining', 'Kitchen Storage',        'kitchen-storage',      null],
        ['kitchen--dining', 'Blenders & Mixers',      'blenders-mixers',      null],
        ['kitchen--dining', 'Coffee & Tea Makers',    'coffee-tea-makers',    null],
        ['kitchen--dining', 'Food Containers',        'food-containers',      null],
        ['kitchen--dining', 'Dining Sets',            'dining-sets',          null],
        ['kitchen--dining', 'Kitchen Cleaning',       'kitchen-cleaning',     null],
        // CARS
        ['cars', 'Petrol Cars',      'petrol-cars',     'https://res.cloudinary.com/dck2vzccq/image/upload/v1780417477/petrol_car_xi6vxs.jpg'],
        ['cars', 'Diesel Cars',      'diesel-cars',     null],
        ['cars', 'Hybrid Cars',      'hybrid-cars',     null],
        ['cars', 'Electric Cars',    'electric-cars',   null],
        ['cars', 'Automatic Cars',   'automatic-cars',  'https://res.cloudinary.com/dck2vzccq/image/upload/v1778834053/f8c1ead3c1e74356878f7c0871eee904_w98axc.jpg'],
        ['cars', 'Manual Cars',      'manual-cars',     null],
        ['cars', 'SUVs',             'suvs',            null],
        ['cars', 'Pickup Trucks',    'pickup-trucks',   null],
        ['cars', 'Minivans & Buses', 'minivans-buses',  null],
        ['cars', 'Motorcycles',      'motorcycles',     null],
        ['cars', 'Car Accessories',  'car-accessories', null],
        ['cars', 'Car Spare Parts',  'car-spare-parts', null],
        // DRINKWARE
        ['drinkware', 'Water Bottle',          'water-bottle',         'https://res.cloudinary.com/dck2vzccq/image/upload/v1780573588/water_bottle_no_2_p1jvhg.jpg'],
        ['drinkware', 'Coffee Bottle',         'coffee-bottle',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1780573765/tea_bottle_aguhpv.webp'],
        ['drinkware', 'Thermos & Flasks',      'thermos-flasks',       null],
        ['drinkware', 'Tumblers',              'tumblers',             null],
        ['drinkware', 'Sports Water Bottles',  'sports-water-bottles', null],
        ['drinkware', 'Glass Bottles',         'glass-bottles',        null],
        ['drinkware', 'Kids Drinking Cups',    'kids-drinking-cups',   null],
        ['drinkware', 'Wine Glasses',          'wine-glasses',         null],
        ['drinkware', 'Mugs',                  'mugs',                 null],
        ['drinkware', 'Juice Jugs & Pitchers', 'juice-jugs-pitchers',  null],
    ];

    $stmt = $conn->prepare("INSERT IGNORE INTO `subcategories` (name, category_id, slug, image)
        SELECT ?, c.id, ?, ? FROM categories c WHERE c.slug = ? LIMIT 1");

    foreach ($subcategories as [$catSlug, $name, $slug, $image]) {
        $stmt->bind_param('ssss', $name, $slug, $image, $catSlug);
        $stmt->execute();
    }
    $stmt->close();
});

run_migration($conn, '009_seed_admin_user', function (mysqli $conn) {
    $emailPlain = strtolower(trim(env('ADMIN_EMAIL', 'admin@thibella.com')));
    $name       = encrypt(env('ADMIN_NAME', 'Thibella'));
    $email      = encrypt($emailPlain);
    $phone      = encrypt(env('ADMIN_PHONE', '+250700000000'));
    $pass       = password_hash(env('ADMIN_PASSWORD', 'Thibella@2025'), PASSWORD_DEFAULT);
    $emailHash  = emailHash($emailPlain);
    $role       = 'admin';

    $stmt = $conn->prepare(
        "INSERT IGNORE INTO `users` (name, email, phone, password, role, email_hash) VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param('ssssss', $name, $email, $phone, $pass, $role, $emailHash);
    $stmt->execute();
    $stmt->close();
});

// ── To add a new migration, append here: ──────────────n";
