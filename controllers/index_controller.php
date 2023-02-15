<?php 
    require_once('../models/Product.php');
    require_once('../models/OrderItem.php');
    require_once('../models/Order.php');

    class IndexController {
        private function create_product() {
            $data = array(
                "name" => $_POST['name'],
                "description" => $_POST['description'],
                "price" => $_POST['price'],
            );
            (new Product())->create($data);
            //immediately return all available products that include the newly created
            return (new Product())->selectAll();
        }

        private function get_product(): array {
            return (new Product())->find(['id' => $_GET['product_id']]);
        }

        private function get_products() : array {
            return (new Product())->selectAll();
        }

        private function add_to_cart(): array {
            return (new Product())->find(['id' => $_POST['item_id']]);
        }

        private function ordered_items(): array {
            return (new OrderItem())->selectAll();
        }

        private function get_orders(): array {
            return (new Order())->selectAll();
        }

        public function callFunction($function_name) : void {
            header('Content-Type: application/json; charset=utf-8');
            if(method_exists($this, strtolower($function_name))) {
                try {
                    echo json_encode($this->{$function_name}());
                } catch(\Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
        }
    }

    (new IndexController())->callFunction($_GET['func']);
