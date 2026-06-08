<?php

$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'thibella_db';

$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== Thibella Migration ===\n\n";

// ── 1. Drop & recreate database ───────────────────────────────────────────────
$conn->query("DROP DATABASE IF EXISTS `$database`");
echo "✔ Database dropped\n";

$conn->query("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
echo "✔ Database created\n";

$conn->select_db($database);
$conn->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");

// ── 2. Create tables ──────────────────────────────────────────────────────────

$conn->query("
    CREATE TABLE `categories` (
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
echo "✔ Table 'categories' created\n";

$conn->query("
    CREATE TABLE `subcategories` (
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
echo "✔ Table 'subcategories' created\n";

$conn->query("
    CREATE TABLE `users` (
        `id`         int(11)               NOT NULL AUTO_INCREMENT,
        `name`       varchar(100)          DEFAULT NULL,
        `email`      varchar(150)          DEFAULT NULL,
        `phone`      varchar(20)           DEFAULT NULL,
        `password`   varchar(255)          DEFAULT NULL,
        `role`       enum('admin','user')  DEFAULT 'user',
        `created_at` timestamp             NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "✔ Table 'users' created\n";

$conn->query("
    CREATE TABLE `products` (
        `id`                 int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `productName`        varchar(255)     NOT NULL,
        `description`        text             NOT NULL,
        `priceCents`         int(11)          NOT NULL,
        `size`               varchar(50)      DEFAULT NULL,
        `color`              varchar(50)      DEFAULT NULL,
        `type`               varchar(100)     DEFAULT NULL,
        `isOnSale`           tinyint(1)       DEFAULT 0,
        `category`           varchar(100)     DEFAULT NULL,
        `subcategory`        varchar(100)     DEFAULT NULL,
        `subCategory_id`     int(11)          DEFAULT NULL,
        `category_id`        int(10) UNSIGNED DEFAULT NULL,
        `imageUrl`           varchar(500)     DEFAULT NULL,
        `possibleImagesUrls` longtext         CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
                             CHECK (json_valid(`possibleImagesUrls`)),
        `createdAt`          timestamp        NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `fk_products_category` (`category_id`),
        CONSTRAINT `fk_products_category`
            FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "✔ Table 'products' created\n";

$conn->query("
    CREATE TABLE `orders` (
        `id`                  int(11)      NOT NULL AUTO_INCREMENT,
        `user_id`             int(11)      NOT NULL,
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
        `created_at`          timestamp    NOT NULL DEFAULT current_timestamp(),
        `status`              varchar(20)  DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "✔ Table 'orders' created\n";

$conn->query("
    CREATE TABLE `order_items` (
        `id`                 int(11)      NOT NULL AUTO_INCREMENT,
        `order_id`           int(11)      DEFAULT NULL,
        `product_id`         int(11)      DEFAULT NULL,
        `product_name`       varchar(150) DEFAULT NULL,
        `price_cents`        int(11)      DEFAULT NULL,
        `quantity`           int(11)      DEFAULT NULL,
        `selected_color`     varchar(50)  DEFAULT NULL,
        `selected_size`      varchar(50)  DEFAULT NULL,
        `image_url`          text         DEFAULT NULL,
        `productTotalAmount` int(15)      DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `order_id` (`order_id`),
        CONSTRAINT `order_items_ibfk_1`
            FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");
echo "✔ Table 'order_items' created\n";

// ── 3. Seed categories & subcategories ───────────────────────────────────────
/*
 * To add more categories: add a new key => [...] entry to $categories.
 * To add more subcategories: add a new row to $subcategories using the same category key.
 */

echo "\n--- Seeding categories ---\n";

$categories = [
    'clothing'    => ['Clothes',          'Fashion clothing including shirts, hoodies and trousers',   'clothing',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603874/clothes_gyujfw.jpg'],
    'shoes'       => ['Shoes',            'All types of shoes including sport shoes and casual shoes', 'shoes',           'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603948/shoes_h3vkax.jpg'],
    'electronics' => ['Electronics',      'Electronic devices like watches, headphones and gadgets',   'electronics',     'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603873/download_z7ztb3.jpg'],
    'kitchen'     => ['Kitchen & Dining', 'Kitchen essentials, cookware, utensils and dining sets',    'kitchen--dining', 'https://res.cloudinary.com/dck2vzccq/image/upload/v1777521430/kitchenware_z6ijnc.webp'],
    'cars'        => ['Cars',             'New and used cars, SUVs, trucks and vehicle accessories',   'cars',            'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603873/cars_onrliw.jpg'],
    'drinkware'   => ['Drinkware',        'Bottles, cups, tumblers and drinkware for every lifestyle', 'drinkware',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1777463279/IMG-20260429-WA0020_aqvkmr.jpg'],
];

$catStmt = $conn->prepare(
    "INSERT INTO `categories` (`title`, `description`, `slug`, `image`) VALUES (?, ?, ?, ?)"
);

$categoryIds = [];
foreach ($categories as $key => $cat) {
    $catStmt->bind_param('ssss', $cat[0], $cat[1], $cat[2], $cat[3]);
    $catStmt->execute();
    $categoryIds[$key] = $conn->insert_id;
    echo "  ✔ {$cat[0]} (id={$categoryIds[$key]})\n";
}
$catStmt->close();

echo "\n--- Seeding subcategories ---\n";

// [category_key, name, slug, image]
$subcategories = [

    // ── CLOTHES (20 subcategories) ────────────────────────────────────────────
    ['clothing', 'Clothes (Men)',            'men',                   'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415860/men_clothes_hcmu9u.jpg'],
    ['clothing', 'Clothes (Women)',          'clothes-women',         'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415861/women_clothes_ngdhdo.jpg'],
    ['clothing', 'Kids (Clothes)',           'kids-clothes',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1780415861/kids_subcategory_kuwaty.jpg'],
    ['clothing', 'T-Shirts',                 't-shirts',              null],
    ['clothing', 'Hoodies & Sweatshirts',    'hoodies-sweatshirts',   null],
    ['clothing', 'Shirts & Blouses',         'shirts-blouses',        null],
    ['clothing', 'Jeans',                    'jeans',                 'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602868/a8a7ab0988be437fb5fe2a63148cbda1_tssx6v.jpg'],
    ['clothing', 'Trousers & Chinos',        'trousers-chinos',       null],
    ['clothing', 'Dresses',                  'dresses',               'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602811/26ae817f15784160acdd80663d374bd3_fqewaf.jpg'],
    ['clothing', 'Skirts',                   'skirts',                null],
    ['clothing', 'Jackets & Coats',          'jackets-coats',         null],
    ['clothing', 'Suits & Blazers',          'suits-blazers',         null],
    ['clothing', 'Shorts',                   'shorts',                null],
    ['clothing', 'Activewear & Sportswear',  'activewear-sportswear', null],
    ['clothing', 'Underwear & Lingerie',     'underwear-lingerie',    null],
    ['clothing', 'Socks',                    'socks',                 'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602809/44019494b0414f23a4d5d04ea16d8f88_s9nmqi.jpg'],
    ['clothing', 'Pyjamas & Loungewear',     'pyjamas-loungewear',    null],
    ['clothing', 'Abayas & Modest Wear',     'abayas-modest-wear',    null],
    ['clothing', 'School Uniforms',          'school-uniforms',       null],
    ['clothing', 'Traditional & Cultural',   'traditional-cultural',  null],

    // ── SHOES (13 subcategories) ──────────────────────────────────────────────
    ['shoes', 'For Everyone (Shoes)',    'for-everyone-shoes',  'https://res.cloudinary.com/dck2vzccq/image/upload/v1778603948/shoes_h3vkax.jpg'],
    ['shoes', 'Men\'s Shoes',            'mens-shoes',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602804/7ceb70ac71d24e8ebde7de078415317b_ibome1.jpg'],
    ['shoes', 'Women\'s Shoes',          'womens-shoes',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602852/19af757cd13f4396851a5cedd3fe46f2_ak46tc.jpg'],
    ['shoes', 'Kids\' Shoes',            'kids-shoes',          null],
    ['shoes', 'Sneakers',                'sneakers',            'https://res.cloudinary.com/dck2vzccq/image/upload/v1777284925/4a23a8d5ceeb4e58bb63bc20f6b5f865_odkc6g.jpg'],
    ['shoes', 'Running Shoes',           'running-shoes',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1777284927/d3c4ff57ef51487a82246377016bb5a8_sn8a0r.jpg'],
    ['shoes', 'Sport Shoes',             'sport-shoes',         null],
    ['shoes', 'Casual Shoes',            'casual-shoes',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1778602790/fcc7baf0bd154401a41c685634c2d6cf_lixekr.jpg'],
    ['shoes', 'Formal Shoes',            'formal-shoes',        null],
    ['shoes', 'Boots',                   'boots',               null],
    ['shoes', 'Sandals & Flip Flops',    'sandals-flip-flops',  null],
    ['shoes', 'Heels',                   'heels',               null],
    ['shoes', 'Loafers & Slip-Ons',      'loafers-slip-ons',    null],

    // ── ELECTRONICS (19 subcategories) ───────────────────────────────────────
    ['electronics', 'Mobile Devices',         'mobile-devices',        'https://res.cloudinary.com/dck2vzccq/image/upload/v1780418006/Mobile_Devices_gzp2ph.jpg'],
    ['electronics', 'Smartphone',             'smartphone',            'https://res.cloudinary.com/dck2vzccq/image/upload/v1780562661/smartphoneSubcategory_bmyblm.jpg'],
    ['electronics', 'Keypad Phone',           'keypad-phone',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1780563156/key_pad_phone_btydem.jpg'],
    ['electronics', 'Tablets',                'tablets',               null],
    ['electronics', 'Laptops',                'laptops',               null],
    ['electronics', 'Desktop Computers',      'desktop-computers',     null],
    ['electronics', 'Smartwatches',           'smartwatches',          null],
    ['electronics', 'Watches',                'watches',               'https://res.cloudinary.com/dck2vzccq/image/upload/v1780574815/watches_ecrcpu.jpg'],
    ['electronics', 'Headphones & Earbuds',   'headphones-earbuds',    null],
    ['electronics', 'Bluetooth Speakers',     'bluetooth-speakers',    null],
    ['electronics', 'TV & Monitors',          'tv-monitors',           null],
    ['electronics', 'Cameras & Photography',  'cameras-photography',   null],
    ['electronics', 'Phone Accessories',      'phone-accessories',     'https://res.cloudinary.com/dck2vzccq/image/upload/v1777384133/2efd16286dfb4442ac1c9c7806dfaabf_eh8wqh.jpg'],
    ['electronics', 'Chargers & Cables',      'chargers-cables',       null],
    ['electronics', 'Power Banks',            'power-banks',           null],
    ['electronics', 'Radio',                  'radio',                 'https://res.cloudinary.com/dck2vzccq/image/upload/v1780574668/radion_wpneni.webp'],
    ['electronics', 'Home Appliances',        'home-appliances',       null],
    ['electronics', 'Gaming',                 'gaming',                null],
    ['electronics', 'Printers & Scanners',    'printers-scanners',     null],

    // ── KITCHEN & DINING (13 subcategories) ──────────────────────────────────
    ['kitchen', 'Cookware',                'cookware',              null],
    ['kitchen', 'Bakeware',                'bakeware',              null],
    ['kitchen', 'Kitchen Knives & Tools',  'kitchen-knives-tools',  null],
    ['kitchen', 'Pots & Pans',             'pots-pans',             null],
    ['kitchen', 'Plates & Bowls',          'plates-bowls',          null],
    ['kitchen', 'Cups & Mugs',             'cups-mugs',             null],
    ['kitchen', 'Cutlery & Utensils',      'cutlery-utensils',      null],
    ['kitchen', 'Kitchen Storage',         'kitchen-storage',       null],
    ['kitchen', 'Blenders & Mixers',       'blenders-mixers',       null],
    ['kitchen', 'Coffee & Tea Makers',     'coffee-tea-makers',     null],
    ['kitchen', 'Food Containers',         'food-containers',       null],
    ['kitchen', 'Dining Sets',             'dining-sets',           null],
    ['kitchen', 'Kitchen Cleaning',        'kitchen-cleaning',      null],

    // ── CARS (12 subcategories) ───────────────────────────────────────────────
    ['cars', 'Petrol Cars',       'petrol-cars',       'https://res.cloudinary.com/dck2vzccq/image/upload/v1780417477/petrol_car_xi6vxs.jpg'],
    ['cars', 'Diesel Cars',       'diesel-cars',       null],
    ['cars', 'Hybrid Cars',       'hybrid-cars',       null],
    ['cars', 'Electric Cars',     'electric-cars',     null],
    ['cars', 'Automatic Cars',    'automatic-cars',    'https://res.cloudinary.com/dck2vzccq/image/upload/v1778834053/f8c1ead3c1e74356878f7c0871eee904_w98axc.jpg'],
    ['cars', 'Manual Cars',       'manual-cars',       null],
    ['cars', 'SUVs',              'suvs',              null],
    ['cars', 'Pickup Trucks',     'pickup-trucks',     null],
    ['cars', 'Minivans & Buses',  'minivans-buses',    null],
    ['cars', 'Motorcycles',       'motorcycles',       null],
    ['cars', 'Car Accessories',   'car-accessories',   null],
    ['cars', 'Car Spare Parts',   'car-spare-parts',   null],

    // ── DRINKWARE (10 subcategories) ──────────────────────────────────────────
    ['drinkware', 'Water Bottle',           'water-bottle',          'https://res.cloudinary.com/dck2vzccq/image/upload/v1780573588/water_bottle_no_2_p1jvhg.jpg'],
    ['drinkware', 'Coffee Bottle',          'coffee-bottle',         'https://res.cloudinary.com/dck2vzccq/image/upload/v1780573765/tea_bottle_aguhpv.webp'],
    ['drinkware', 'Thermos & Flasks',       'thermos-flasks',        null],
    ['drinkware', 'Tumblers',               'tumblers',              null],
    ['drinkware', 'Sports Water Bottles',   'sports-water-bottles',  null],
    ['drinkware', 'Glass Bottles',          'glass-bottles',         null],
    ['drinkware', 'Kids Drinking Cups',     'kids-drinking-cups',    null],
    ['drinkware', 'Wine Glasses',           'wine-glasses',          null],
    ['drinkware', 'Mugs',                   'mugs',                  null],
    ['drinkware', 'Juice Jugs & Pitchers',  'juice-jugs-pitchers',   null],
];

$subStmt = $conn->prepare(
    "INSERT INTO `subcategories` (`name`, `category_id`, `slug`, `image`) VALUES (?, ?, ?, ?)"
);

foreach ($subcategories as $sub) {
    [$catKey, $name, $slug, $image] = $sub;
    $catId = $categoryIds[$catKey];
    $subStmt->bind_param('siss', $name, $catId, $slug, $image);
    $subStmt->execute();
    echo "  ✔ [{$catKey}] {$name} (id={$conn->insert_id})\n";
}
$subStmt->close();

$conn->close();
echo "\n✅ Migration complete.\n";
