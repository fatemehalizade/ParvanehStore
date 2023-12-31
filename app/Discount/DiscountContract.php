<?php
    namespace App\Discount;

    use Illuminate\Http\Request;

    interface DiscountContract{
        public function GetRows();
        public function GetAll();
        public function GetData($id);
        public function Create(Request $request);
        public function Update(Request $request,$id);
        public function Delete($id);
        public function DataFormat($discountInfo);
    }
?>
