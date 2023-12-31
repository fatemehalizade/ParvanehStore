<?php
    namespace App\Score;

    use App\Models\Score;
    use Illuminate\Http\Request;
    class ScoreClass implements ScoreContract{
        public function Create(Request $request,$userId){
            $score=new Score();
            $score->score=$request->score;
            $score->product_id=$request->productId;
            $score->user_id=$userId;
            $score->save();
        }
        public function GetData($productId){
            return Score::where("product_id",$productId)->get();
        }
        public function CheckUser($userId,$productId){
            return Score::where("product_id",$productId)->where("user_id",$userId)->get();
        }
        public function GetScore($productId){
            $productScore=0;
            $scoresList=$this->GetData($productId);
            if(count($scoresList) != 0){
                foreach ($scoresList as $key => $score) {
                    $productScore += $score->score;
                }
                return $productScore/count($scoresList);
            }
            return $productScore;
        }
        public function ScoreFormat($scoreInfo){
            $product=$scoreInfo->Product;
            $productInfo=$product->ProductInfo;
            $userInfo=$scoreInfo->User;
            return [
                "id" => $scoreInfo->id ,
                "score" => $scoreInfo->score ,
                "productInfo" => [
                    "id" => $product->id ,
                    "code" => $product->code ,
                    "image" => $productInfo->image ,
                    "name" => $productInfo->name ,
                    "price" => $product->price
                ] ,
                "userInfo" => [
                    "id" => $userInfo->id ,
                    "image" => $userInfo->image ,
                    "fullName" => $userInfo->full_name ,
                    "email" => $userInfo->email
                ],
                "updatedAt" => convertDateToFarsi($scoreInfo->updated_at)
            ];
        }
    }
?>
