<?php
    namespace App\Order;
    use App\Models\Order;

    class OrderClass implements OrderContract{
        public function GetAlls(){
            return Order::orderBy("id","DESC")->get();
        }
        public function GetAll($userId){
            return Order::where("user_id",$userId)->orderBy("id","DESC")->get();
        }
        public function GetRows(){
            $startDate=date("Y-m-d 00:00:00");
            $finishDate=date("Y-m-d 23:59:59");
            return Order::where("created_at",">=",$startDate)->where("created_at","<=",$finishDate)->orderBy("id","DESC")->get();
        }
        public function Create($infos){
            $order=new Order();
            $order->product_id=$infos["productId"];
            // $order->product_count=$infos["productCount"];
            $order->off=$infos["off"];
            $order->price=$infos["totalPrice"];
            $order->user_id=$infos["userId"];
            $order->save();
        }
        public function GetData($id){
            return Order::findOrFail($id);
        }
        public function GetOrder($productId,$userId,$status){
            return Order::where("product_id",$productId)->where("user_id",$userId)->where("status",$status)->get();
        }
        public function GetOrders($userId,$status){
            return Order::where("user_id",$userId)->where("status",$status)->orderBy("id","DESC")->get();
        }
        public function UpdateStatus($id,$status){
            $order=$this->GetData($id);
            $order->status=$status;
            $order->updated_at=date("Y-m-d H:i:s");
            $order->save();
        }
        public function Add($orderId){
            $order=$this->GetData($orderId);
            $product=$order->Product;
            $order->product_count += 1;
            $price=$product->price * $order->product_count;
            $offPrice=$price*($order->off/100);
            $totalPrice=$price - $offPrice;
            $order->price=$totalPrice;
            $order->save();
            return $order;
        }
        public function Delete($id){
            $order=$this->GetData($id);
            if($order->product_count == 1){
                $order->delete();
            }
            else{
                $product=$order->Product;
                $order->product_count -= 1;
                $price=$product->price * $order->product_count;
                $offPrice=$price*($order->off/100);
                $totalPrice=$price - $offPrice;
                $order->price=$totalPrice;
                $order->save();
            }
            return $order;
        }
        public function OrderFormat($orderInfo){
            $product=$orderInfo->Product;
            $productInfo=$product->ProductInfo;
            if($orderInfo->status == 0){
                $status="در انتظار پرداخت";
            }
            else if($orderInfo->status == 1){
                $status="پرداخت نشده";
            }
            else{
                $status="پرداخت شده";
            }
            return [
                "id" => $orderInfo->id ,
                "productInfo" => [
                    "id" => $product->id ,
                    "code" => $product->code ,
                    "image" => $productInfo ? $productInfo->image : null ,
                    "name" => $productInfo ? $productInfo->name : null ,
                    "price" => $product->price
                ] ,
                "productCount" => $orderInfo->product_count ,
                "off" => $orderInfo->off ,
                "totalPrice" => $orderInfo->price ,
                "status" => $status ,
                "updatedAt" => convertDateToFarsi($orderInfo->updated_at)
            ];
        }
    }
?>
