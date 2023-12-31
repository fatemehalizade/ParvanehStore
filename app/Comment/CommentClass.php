<?php
    namespace App\Comment;

    use App\Models\Comment;
    use Illuminate\Http\Request;
    class CommentClass implements CommentContract{
        private static $List;
        public function GetAllComments(){
            return Comment::orderBy("id","DESC")->get();
        }
        public function GetUserAllComments($userId){
            return Comment::where("user_id",$userId)->orderBy("id","DESC")->get();
        }
        public function GetRows($commentId=0,$productId){
            return Comment::where("comment_id",$commentId)->where("product_id",$productId)->where("status",1)->orderBy("id","DESC")->get();
        }
        public function GetAll($commentId=0){
            return Comment::where("comment_id",$commentId)->orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Comment::findOrFail($id);
        }
        public function SubCommentsList($commentInfo,$panel,$productId=0){
            $panel == 1 ? $subComments=$this->GetAll($commentInfo->id) : $subComments=$this->GetRows($commentInfo->id,$productId);
            if(count($subComments) != 0){
                foreach ($subComments as $key => $subComment) {
                    $commentIdInfo=$this->GetData($subComment->id);
                    $subComment["comment_id_comment"]=$commentIdInfo->comment;
                    self::$List[]=$subComment;
                    $this->SubCommentsList($subComment,$panel,$productId);
                }
            }
            return [];
        }
        public function CommentsList($panel,$productId=0){
            $panel == 1 ? $firstLevelComments=$this->GetAll() : $firstLevelComments=$this->GetRows(0,$productId);
            if(count($firstLevelComments) != 0){
                foreach ($firstLevelComments as $key => $firstLevelComment) {
                    self::$List[]=$firstLevelComment;
                    $subComments=$this->SubCommentsList($firstLevelComment,$panel,$productId);
                    if(count($subComments) != 0){
                        self::$List[]=$subComments;
                    }
                }
                return self::$List;
            }
            return [];
        }
        public function DetermineStatus($id,$status){
            $comment=$this->GetData($id);
            $comment->status=$status;
            $comment->save();
        }
        public function Create(Request $requset,$userId){
            $comment=new Comment();
            $comment->comment=$requset->comment;
            $comment->product_id=$requset->productId;
            $comment->comment_id=$requset->commentId;
            $comment->user_id=$userId;
            $comment->save();
        }
        public function DataFormat($commentInfo){
            $product=$commentInfo->Product;
            $productInfo=$product->ProductInfo;
            $userInfo=$commentInfo->User;
            $commentIdInfo="---";
            if($commentInfo->comment_id != 0){
                $commentIdInfo=$this->GetData($commentInfo->comment_id)->comment;
            }
            return [
                "id" => $commentInfo->id ,
                "comment" => $commentInfo->comment ,
                "status" => $commentInfo->status ,
                "parentCommentInfo" => $commentIdInfo ,
                "productInfo" => [
                    "id" => $product->id,
                    "code" => $product->code ,
                    "image" => $productInfo->image ,
                    "name" => $productInfo->name
                ] ,
                "userInfo" => [
                    "fullName" => $userInfo->full_name ,
                    "email" => $userInfo->email
                ] ,
                "updatedAt" =>  convertDateToFarsi($commentInfo->updated_at)
            ];
        }
    }
?>
