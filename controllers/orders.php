<?php 
    require_once('../models/Order.php');
    $order = new Order();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($order->selectAll());