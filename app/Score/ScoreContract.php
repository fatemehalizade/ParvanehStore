<?php
    namespace App\Score;
    use Illuminate\Http\Request;

    interface ScoreContract{
        public function Create(Request $request,$userId);
        public function GetData($id);
        public function CheckUser($userId,$productId);
        public function GetScore($id);
        public function ScoreFormat($scoreInfo);
    }
?>
