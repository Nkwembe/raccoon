<?php 
    require_once('../models/Product.php');
    $product = new Product();
    header('Content-Type: application/json; charset=utf-8');
    $data = [
        "name" => $_POST['name'],
        "description" => $_POST['description'],
        "price" => $_POST['price'],
    ];
    $product->create($data);
    //get all latest
    echo json_encode($product->selectAll());
