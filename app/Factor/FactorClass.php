<?php
    namespace App\Factor;
    use App\Models\Factor;

    class FactorClass implements FactorContract{
        public function GetAll(){
            return Factor::orderBy("id","DESC")->get();
        }
        public function GetUserRows($userId){
            return Factor::where("user_id",$userId)->orderBy("id","DESC")->get();
        }
        public function GetUserEnableFactor($userId){
            return Factor::where("user_id",$userId)->where("status",1)->orderBy("id","DESC")->get();
        }
        public function Create($userId){
            $factor=new Factor();
            $factor->factor_code=rand(1000000,9999999);
            $factor->user_id=$userId;
            $factor->status=1;
            $factor->save();
            return $factor;
        }
        public function GetData($id){
            return Factor::findOrFail($id);
        }
        public function UpdateStatus($id,$status){
            $factor=$this->GetData($id);
            $factor->status=$status;
            $factor->updated_at=date("Y-m-d H:i:s");
            $factor->save();
        }
        public function FactorFormat($factorInfo){
            $userInfo=$factorInfo->User;
            if($factorInfo->status == 1){
                $status="پرداخت نشده";
            }
            else{
                $status="پرداخت شده";
            }
            return [
                "id" => $factorInfo->id ,
                "factorCode" => $factorInfo->factor_code ,
                "userInfo" => [
                    "id" => $userInfo->id ,
                    "image" => $userInfo->image ,
                    "fullName" => $userInfo->full_name ,
                    "email" => $userInfo->email ,
                    "mobileNumber" => $userInfo->mobile_number ,
                    "address" => $userInfo->address
                ] ,
                "status" => $status ,
                "updatedAt" => convertDateToFarsi($factorInfo->updated_at)
            ];
        }
    }
?>
