<?php
    namespace App\Producer;

    use App\Models\Producer;
    use Illuminate\Http\Request;

    class ProducerClass implements ProducerContract{
        public function GetRows(){
            return Producer::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Producer::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Producer::findOrFail($id);
        }
        public function Create(Request $request){
            $producer=new Producer();
            $imageInfo=$request->file("image");
            $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
            $producer->image=$imageInfo->storeAs("upload",$newName,"public");
            $producer->producer=$request->producerName;
            $producer->save();
        }
        public function Update(Request $request,$id){
            $producer=$this->GetData($id);
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                unlink("storage/".$producer->image);
                $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
                $producer->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $producer->producer=$request->producerName;
            $producer->updated_at=date("Y-m-d H:i:s");
            $producer->save();
        }
        public function Delete($id){
            $producer=$this->GetData($id);
            unlink("storage/".$producer->image);
            $producer->delete();
        }
    }
?>
