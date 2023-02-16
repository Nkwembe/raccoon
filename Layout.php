<?php

class Layout
{
    public static function view($content) {
        $txt=<<<cin
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                <title>Cart Items Exercise</title>
            </head>
            <body>
                <div class="parent container d-flex justify-content-center align-items-center h-100">
                <div class="card text-center">
                    <div class="card-body justify-content-center">
                        <h5 class="card-title">Products</h5>
                        <div id="products-list">{$content}</div>
                            <p class="lead">Please use the form below to add more products.</p>
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-primary">Add Product</span>
                            </h4>
                            <form class="card p-2" method="POST" action="/product/create">
                                <div class="input-group">
                                    <input type="text" name="name" value="" id="name" class="form-control" placeholder="Name">
                                    <input type="text" name="description" id="desc" value="" class="form-control" placeholder="description">
                                    <input type="number" name="amount" id="price" value class="form-control" placeholder="Price">
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <script src="js/shop.js"></script>
            </body>
        </html>
        cin;
        return $txt;
    }

    public static function navigation($base,$id) {
        return'';
    }
}