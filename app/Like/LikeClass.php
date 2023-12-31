<?php
    namespace App\Like;
    use App\Models\Like;
    use App\Models\LikeUser;

    class LikeClass implements LikeContract {
        public function SortMoreLikes(){
            return Like::orderBy("count","DESC")->get();
        }
        public function GetAll(){
            return Like::orderBy("id","DESC")->get();
        }
        public function GetUserAllLikes($userId){
            return LikeUser::select("like_id")->where("user_id",$userId)->orderBy("id","DESC")->get();
        }
        public function CheckUserLike($userId){
            $ids=$this->GetUserAllLikes($userId);
            return Like::whereIn("id",$ids)->get();
        }
        public function GetUserLike($userId,$likeId){
            return LikeUser::where("user_id",$userId)->where("like_id",$likeId)->get();
        }
        public function GetData($productId){
            return Like::where("product_id",$productId)->get();
        }
        public function GetLikeData($id){
            return Like::where("id",$id)->get()[0];
        }
        public function Create($productId){
            $like=new Like();
            $like->product_id=$productId;
            $like->save();
        }
        public function LikeUpdate($productId,$userId){
            $like=$this->GetData($productId)[0];
            $like->count += 1;
            $like->save();
            $like->User()->attach($userId);
        }
        public function DisLikeUpdate($productId,$userId){
            $like=$this->GetData($productId)[0];
            if($like->count != 0){
                $like->count -= 1;
                $this->GetUserLike($userId,$like->id)[0]->delete();
            }
            $like->save();
        }
        public function LikeFormat($likeUserInfo){
            $likeInfo=$likeUserInfo[0];
            $product=$likeInfo->Product;
            $productInfo=$product->ProductInfo;
            return [
                "id" => $likeInfo->id ,
                "likeCount" => $likeInfo->count ,
                "productInfo" => [
                    "id" => $product->id ,
                    "code" => $product->code ,
                    "price" => $product->price ,
                    "image" => $productInfo->image ,
                    "name" => $productInfo->name ,
                    "weight" => $productInfo->weight ,
                    "healthLicenceNumber" => $productInfo->health_licence_number
                ] ,
                "updatedAt" => convertDateToFarsi($likeInfo->updated_at)
            ];
        }
    }
?>
