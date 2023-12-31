<?php
    namespace App\Profile;
    use App\Models\ContactUs;
    use App\Models\Profile;
    use Illuminate\Http\Request;

    class ProfileClass implements ProfileContract{
        public function GetData(){
            return Profile::get()[0];
        }
        public function Update(Request $request,$id){
            $profile=$this->GetData();
            $logoInfo=$request->file("logo");
            if(!is_null($logoInfo)){
                if(!is_null($profile->logo)){
                    unlink("storage/".$profile->logo);
                }
                $newName=md5(time())."_".rand(100000,999999).".".$logoInfo->getClientOriginalExtension();
                $profile->logo=$logoInfo->storeAs("upload",$newName,"public");
            }
            $profile->name=$request->name;
            $profile->email=$request->email;
            $profile->mobile_number=$request->mobileNumber;
            $profile->phone_number=$request->phoneNumber;
            $profile->description=$profile->description;
            $profile->updated_at=date("Y-m-d H:i:s");
            $profile->save();
        }
    }
?>
