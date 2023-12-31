<?php
    namespace App\Like;

    interface LikeContract{
        public function SortMoreLikes();
        public function GetAll();
        public function GetUserAllLikes($userId);
        public function GetUserLike($userId,$likeId);
        public function GetData($productId);
        public function GetLikeData($id);
        public function Create($productId);
        public function LikeUpdate($productId,$userId);
        public function DisLikeUpdate($productId,$userId);
        public function CheckUserLike($userId);
        public function LikeFormat($likeUserInfo);
    }
?>
