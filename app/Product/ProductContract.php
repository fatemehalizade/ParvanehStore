<?php
    namespace App\Product;

use Illuminate\Http\Request;

    interface ProductContract{
        public function GetRowsIds();
        public function GetAllIds();
        public function GetData($id);
        public function GetProductByBrand($brandId);
        public function GetProductByCategory($categoryId);
        public function Create(Request $request);
        public function Update(Request $request,$id);
        public function UpdateProductCount(Request $request,$id);
        public function Delete($id);
        public function SearchProducts(Request $request);
        public function DataFormat($product,$productInfo);
    }
?>
