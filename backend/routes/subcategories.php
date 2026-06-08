<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controllers/SubcategoryController.php';

dispatch(new SubcategoryController());
