<?php
    namespace App\Factor;
    use App\Models\Factor;

    interface FactorContract{
        public function GetAll();
        public function GetUserRows($userId);
        public function GetUserEnableFactor($userId);
        public function Create($userId);
        public function GetData($id);
        public function UpdateStatus($id,$status);
        public function FactorFormat($factorInfo);
    }
?>
