<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controllers/CategoryController.php';

dispatch(new CategoryController());
