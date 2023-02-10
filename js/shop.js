$(document).ready(function () {
    const prod_on_cart = [];
    $.ajax({
        url: "controllers/products.php",
        method: 'GET',
        success: function (products) {
            let html = "";
            if (Array.isArray(products) && products.length > 0) {
                html += '<ul class="list-group mb-3 products">';
               for (let i = 0; i < products.length; i++) {
                   html += _productListItem(products[i]);
                }
                html += '</ul>';
                $("#products-list").html(html);
            } else {
                $("#products-list").html('<p>No product is available.</p>');
           }
        },
        statusCode: {
            404: function () {
                alert("Server end point not found.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    }).done(function () {
        console.log('done');
    });

    $(document).on('click', '.addToCart', function (e) {
        e.preventDefault();
        let id = e.currentTarget.getAttribute('data-id');
        _addToCart(id);
    })
    $(document).on('click', '.removeCartItem', function (e) {
        e.preventDefault();
        let id = e.currentTarget.getAttribute('data-id');
        _removeCartItem(id);
        _countCartItems();
    })
    $(document).on('click', '.add-product', function (e) {
        e.preventDefault();
        _addProduct();
    })

    function _removeProductFormList(id) {
        $('li.product-' + id).remove();
    }

    function _removeCartItem(id) {
        $('li.cart-item.item-' + id).remove();
        _countCartItems();
        $.ajax({
            url: "controllers/get_product.php?product_id=" + id,
            method: 'GET',
            success: function (res) {
                if (typeof res === 'object') {
                    $("#products-list ul").append(_productListItem(res));
                }
            },
            statusCode: {
                404: function () {
                    alert("Server end point not found.");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        }).done(function () {
            console.log('done');
        });
    }
    
    function _addProduct() {
        let data = {};
        data['name'] = document.getElementById("name").value;
        data['description'] = document.getElementById("desc").value;
        data['price'] = parseFloat(document.getElementById("price").value);
        $.ajax({
            url: "controllers/add_product.php",
            method: 'POST',
            data: data,
            success: function (res) {
                let html = "";
                if (Array.isArray(res) && res.length > 0) {
                    html += '<ul class="list-group mb-3 products">';
                    for (let i = 0; i < res.length; i++) {
                        html += _productListItem(res[i]);
                    }
                    html += '</ul>';
                    $("#products-list").html(html);
                }
            },
            statusCode: {
                404: function () {
                    alert("Server end point not found.");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        }).done(function () {
            console.log('done');
        });
    }

    function _checkout() {

    }

    function _addToCart(item_id = 0) {
        $.ajax({
            url: "controllers/add_to_cart.php",
            method: 'POST',
            data: {item_id: item_id, user_id: 1},
            success: function (res) {
                if (typeof res === 'object') {
                    _updateCartList(res);
                    _countCartItems();
                    _removeProductFormList(res.id);
                }
            },
            statusCode: {
                404: function () {
                    alert("Server end point not found.");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        }).done(function () {
            console.log('done');
        });
    }

    function _productListItem(prod) {
        let html = "";
        html += `<li class="list-group-item d-flex justify-content-between lh-sm product-${prod.id}">`;
        html += `<div>`;
        html += `<h6 class="my-0">${prod.name}</h6>`;
        html += `<small class="text-muted">${prod.description}</small>`;
        html += `<p><span class="text-muted"><b>R${prod.price}</b></span></p>`
        html += `</div>`
        html += `${_btns(prod.id, 'product')}`;
        html += `</li>`;
        return html;
    }
    function _updateCartList(obj) {
        let html = "";
        html += `<li class="list-group-item d-flex justify-content-between lh-sm cart-item item-${obj.id}">`;
        html += `<div>`;
        html += `<h6 class="my-0">${obj.name}</h6>`;
        html += `<small class="text-muted">${obj.description}</small>`;
        html += `<div><button data-id="${obj.id}" type="button" class="btn btn-secondary btn-sm removeCartItem">Remove</button></div>`;
        html += `</div>`
        html += `<span class="text-muted"><b>R${obj.price}</b></span>`;
        html += `</li>`;
        $("ul#cart-items").append(html);
    }

    function _btns(item_id = 0, type = "product") {
        let data = `data-id="${item_id}" data-type="${type}"`;
        let btns = '<div>';
        btns += `<a href="#" class="btn btn-primary btn-sm addToCart" ${data} role="button">Add to Cart</a>`;
        btns += `<a href="#" class="btn btn-secondary btn-sm editItem" ${data} role="button">Edit</a>`;
        btns += `<a href="#" class="btn btn-danger btn-sm deleteItem" ${data} role="button">Delete</a>`;
        btns += '</div>'
        return btns;
    }

    function _countCartItems() {
        let arr = document.querySelectorAll('li.cart-item');
        if (arr.length > 0) {
            $('div.checkout').html(`
                <button type="button" class="btn btn-lg btn-primary place-order">
                    Checkout
                </button>
            `);
        } else {
            $('div.checkout').html('');
        }
        $('#total-items').text(arr.length);
    }
})