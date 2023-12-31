<?php
    namespace App\Discount;
    use App\Models\Discount;
    use Illuminate\Http\Request;

    class DiscountClass implements DiscountContract{
        public function GetRows(){
            return Discount::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Discount::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Discount::findOrFail($id);
        }
        public function Create(Request $request){
            $discount=new Discount();
            $discount->percent=$request->percent;
            $discount->start=$request->startDate;
            $discount->finish=$request->finishDate;
            $discount->product_id=$request->productId;
            $discount->save();
        }
        public function Update(Request $request,$id){
            $discount=$this->GetData($id);
            $discount->percent=$request->percent;
            $discount->start=$request->startDate;
            $discount->finish=$request->finishDate;
            $discount->product_id=$request->productId;
            $discount->updated_at=date("Y-m-d H:i:s");
            $discount->save();
        }
        public function Delete($id){
            $discount=$this->GetData($id);
            $discount->delete();
        }
        public function DataFormat($discountInfo){
            $product=$discountInfo->Product;
            $productInfo=$product->ProductInfo;
            return [
                "id" => $discountInfo->id ,
                "percent" => $discountInfo->percent ,
                "startDate" => $discountInfo->start ,
                "finishDate" => $discountInfo->finish ,
                "productInfo" => [
                    "id" => $product->id ,
                    "code" => $product->code ,
                    "image" => $productInfo->image ,
                    "name" => $productInfo->name ,
                    "price" => $product->price
                ] ,
                "updatedAt" => convertDateToFarsi($discountInfo->updated_at)
            ];
        }
    }
?>
