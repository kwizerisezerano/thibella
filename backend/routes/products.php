<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controllers/ProductController.php';

dispatch(new ProductController());
