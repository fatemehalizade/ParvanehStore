<?php
    namespace App\Order;
    use App\Models\Order;

    interface OrderContract{
        public function GetAlls();
        public function GetAll($userId);
        public function GetRows();
        public function Create($infos);
        public function GetData($id);
        public function GetOrder($productId,$userId,$status);
        public function GetOrders($userId,$status);
        public function UpdateStatus($id,$status);
        public function Add($orderId);
        public function Delete($id);
        public function OrderFormat($orderInfo);
    }
?>
