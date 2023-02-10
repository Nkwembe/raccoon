<?php 
    require_once('../models/Product.php');
    $product = new Product();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($product->selectAll());