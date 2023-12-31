<?php
    namespace App\User;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class UserClass implements UserContract{
        public function getRows(){
            return User::orderBy("id","DESC")->paginate(10);
        }
        public function getAll(){
            return User::orderBy("id","DESC")->get();
        }
        public function Create(Request $request){
            $user=new User();
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
                $user->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $user->full_name=$request->fullName;
            $user->email=$request->email;
            $user->national_code=$request->nationalCode;
            $user->mobile_number=$request->mobileNumber;
            $user->username=$request->username;
            $user->password=Hash::make($request->password);
            $user->save();
            $user->Role()->attach(2);
        }
        public function GetData($id){
            return User::findOrFail($id);
        }
        public function GetDataByAPItoken($APItoken){
            return User::where("api_token",$APItoken)->get();
        }
        public function UpdateAPItoken($id){
            $user=$this->GetData($id);
            $user->api_token=md5(time().$id);
            $user->save();
            return $user;
        }
        public function Delete($id){
            $user=$this->GetData($id);
            if(!is_null($user->image)){
                unlink("storage/".$user->image);
            }
            $user->delete();
        }
        public function Update(Request $request,$id){
            $user=$this->GetData($id);
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                if($user->image){
                    unlink("storage/".$user->image);
                }
                $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
                $user->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $user->full_name=$request->fullName;
            $user->email=$request->email;
            $user->national_code=$request->nationalCode;
            $user->mobile_number=$request->mobileNumber;
            $user->username=$request->username;
            if(!is_null($request->password)){
                $user->password=Hash::make($request->password);
            }
            $user->updated_at=date("Y-m-d H:i:s");
            $user->save();
        }
    }

?>
