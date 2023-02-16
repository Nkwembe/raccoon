<?php
use eftec\routeone\RouteOne;
require_once "./vendor/autoload.php";
require_once "Layout.php";
require_once "./controllers/ProductController.php";
require_once "./models/Product.php";
require_once "./models/Order.php";
require_once "./models/OrderItem.php";
$product = new Product();
$order = new Order();
$orderItem = new OrderItem();
$route=new RouteOne(".",null,false);
$route->setDefaultValues('product','index');//default indexAction
$route->fetch();
$route->callObjectEx('raccoon\controllers\{controller}Controller');