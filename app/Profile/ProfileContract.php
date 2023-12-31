<?php
    namespace App\Profile;
    use Illuminate\Http\Request;

    interface ProfileContract{
        public function GetData();
        public function Update(Request $request,$id);
    }
?>
