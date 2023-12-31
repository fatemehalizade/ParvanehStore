<?php
    namespace App\User;

    use Illuminate\Http\Request;

    interface UserContract{
        public function getRows();
        public function getAll();
        public function Create(Request $request);
        public function GetData($id);
        public function GetDataByAPItoken($APItoken);
        public function UpdateAPItoken($id);
        public function Delete($id);
        public function Update(Request $request,$id);
    }
?>
