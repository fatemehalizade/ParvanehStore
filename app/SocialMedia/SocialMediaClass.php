<?php
    namespace App\SocialMedia;
    use App\Models\SocialMedia;
    use Illuminate\Http\Request;

    class SocialMediaClass implements  SocialMediaContract {
        public function GetRows(){
            return SocialMedia::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return SocialMedia::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return SocialMedia::where("id",$id)->get()[0];
        }
        public function Create(Request $request){
            $socialMedia=new SocialMedia();
            $imageInfo=$request->file("image");
            $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
            $socialMedia->image=$imageInfo->storeAs("upload",$newName,"public");
            $socialMedia->name=$request->name;
            $socialMedia->url=$request->URL;
            $socialMedia->save();
        }
        public function Update(Request $request,$id){
            $socialMedia=$this->GetData($id);
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                unlink("storage/".$socialMedia->image);
                $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
                $socialMedia->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $socialMedia->name=$request->name;
            $socialMedia->url=$request->URL;
            $socialMedia->updated_at=date("Y-m-d H:i:s");
            $socialMedia->save();
        }
        public function Delete($id){
            $socialMedia=$this->GetData($id);
            unlink("storage/".$socialMedia->image);
            $socialMedia->delete();
        }
    }
?>
