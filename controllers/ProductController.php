<?php

namespace raccoon\controllers;

class ProductController
{
    public function indexAction(): void {
        $this->productsAction();
    }

    public function createAction() {
        global $product;
        try {
            $pattern = "/[^_a-z0-9- ]/i";
            $data = array(
                "name" => preg_replace($pattern,'',$_POST['name']),
                "description" => preg_replace($pattern,'',$_POST['description']),
                "price" => $_POST['amount'],
            );
            $product->create($data);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch(\Exception $e) {
            echo \Layout::view($e->getMessage());
        }
    }

    public function getProductAction(): void {
        global $product;
        try {
            $p = $product->find(['id' => $_GET['product_id']]);
            echo \Layout::view( "<p>{$p->name} {$p->description} R{$p->price}</p>");
        } catch(\Exception $e) {
            echo \Layout::view( $e->getMessage());
        }
    }

    public function productsAction() {
        try {
            global $product;
            $products = $product->selectAll();
            $str = '';
            foreach($products as $prod) {
                $str .= "<p>{$prod['name']} {$prod['description']} R{$prod['price']}</p>";
            }
            echo \Layout::view( $str );
        } catch(\Exception $e) {
           echo \Layout::view( $e->getMessage());
        }
    }

    public function addToCartAction(): void {
        global $product;
        try {
            //should be about creating item into order_items table 
            $produt_to_add = $product->find(['id' => $_POST['item_id']]);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch(\Exception $e) {
           echo \Layout::view( $e->getMessage());
        }
    }

    public function orderedItemsAction(): void {
        global $orderItem;
        try {
            $items = $orderItem->selectAll();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch(\Exception $e) {
           echo \Layout::view( $e->getMessage());
        }
    }

    public function getOrdersAction(): void {
        global $order;
        try {
            $items = $order->selectAll();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch(\Exception $e) {
            echo \Layout::view( $e->getMessage());
        }
    }
}