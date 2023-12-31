<?php
    namespace App\Category;

use Illuminate\Http\Request;

    interface CategoryContract{
        public function GetRows($categoryId=0,$level=1);
        public function CategoryList($categoryId=0);
        public function SubCategoriesList($categoryInfo);
        public function GetData($id);
        public function Create(Request $request);
        public function Update(Request $request,$id);
        public function Delete($id);
    }
?>
