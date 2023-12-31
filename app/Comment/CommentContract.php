<?php
    namespace App\Comment;
    use Illuminate\Http\Request;

    interface CommentContract{
        public function GetAllComments();
        public function GetUserAllComments($userId);
        public function GetRows($commentId=0,$productId);
        public function GetAll($commentId=0);
        public function GetData($id);
        public function SubCommentsList($commentInfo,$panel,$productId=0);
        public function CommentsList($panel,$productId=0);
        public function DetermineStatus($id,$status);
        public function Create(Request $requset,$userId);
        public function DataFormat($commentInfo);
    }
?>
