<?php 
    require_once('../models/OrderItem.php');
    $order_item = new OrderItem();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($order_item->selectAll());