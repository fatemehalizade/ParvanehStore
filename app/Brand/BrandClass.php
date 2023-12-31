<?php
    namespace App\Brand;

    use App\Models\Brand;
    use Illuminate\Http\Request;

    class BrandClass implements BrandContract{
        public function GetRows(){
            return Brand::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Brand::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Brand::findOrFail($id);
        }
        public function Create(Request $request){
            $brand=new Brand();
            $imageInfo=$request->file("image");
            $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
            $brand->image=$imageInfo->storeAs("upload",$newName,"public");
            $brand->brand=$request->brandName;
            $brand->save();
        }
        public function Update(Request $request,$id){
            $brand=$this->GetData($id);
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                unlink("storage/".$brand->image);
                $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
                $brand->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $brand->brand=$request->brandName;
            $brand->updated_at=date("Y-m-d H:i:s");
            $brand->save();
        }
        public function Delete($id){
            $brand=$this->GetData($id);
            unlink("storage/".$brand->image);
            $brand->delete();
        }
    }
?>
