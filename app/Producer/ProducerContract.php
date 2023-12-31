<?php
    namespace App\Producer;

use Illuminate\Http\Request;

    interface ProducerContract{
        public function GetRows();
        public function GetAll();
        public function GetData($id);
        public function Create(Request $request);
        public function Update(Request $request,$id);
        public function Delete($id);
    }
?>