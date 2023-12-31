<?php
    namespace App\PackageType;

use App\Models\Package_Type;
use Illuminate\Http\Request;

    class PackageTypeClass implements PackageTypeContract{
        public function GetRows(){
            return Package_Type::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Package_Type::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Package_Type::findOrFail($id);
        }
        public function Create(Request $request){
            $packageType=new Package_Type();
            $packageType->type=$request->packageTypeName;
            $packageType->save();
        }
        public function Update(Request $request,$id){
            $packageType=$this->GetData($id);
            $packageType->type=$request->packageTypeName;
            $packageType->updated_at=date("Y-m-d H:i:s");
            $packageType->save();
        }
        public function Delete($id){
            $packageType=$this->GetData($id);
            $packageType->delete();
        }
    }
?>