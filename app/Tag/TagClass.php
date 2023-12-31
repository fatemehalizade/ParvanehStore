<?php
    namespace App\Tag;

    use App\Models\Tag;
    use Illuminate\Http\Request;

    class TagClass implements TagContract{
        public function GetRows(){
            return Tag::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Tag::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Tag::findOrFail($id);
        }
        public function Create(Request $request){
            $tag=new Tag();
            $tag->tag=$request->tagName;
            $tag->save();
        }
        public function Update(Request $request,$id){
            $tag=$this->GetData($id);
            $tag->tag=$request->tagName;
            $tag->updated_at=date("Y-m-d H:i:s");
            $tag->save();
        }
        public function Delete($id){
            $tag=$this->GetData($id);
            $tag->delete();
        }
    }
?>
