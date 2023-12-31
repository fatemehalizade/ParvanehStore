<?php
    namespace App\Gallery;

    use App\Models\Gallery;
    use Illuminate\Http\Request;

    class GalleryClass implements GalleryContract{
        public function GetRows(){
            return Gallery::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return Gallery::orderBy("id","DESC")->get();
        }
        public function GetData($id){
            return Gallery::findOrFail($id);
        }
        public function GetProductGallery($productId){
            return Gallery::where("product_id",$productId);
        }
        public function Create(Request $request){
            $gallery=new Gallery();
            $imageInfo=$request->file("image");
            $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
            $gallery->image=$imageInfo->storeAs("upload",$newName,"public");
            $gallery->product_id=$request->productId;
            $gallery->save();
        }
        public function Delete($id){
            $gallery=$this->GetData($id);
            unlink("storage/".$gallery->image);
            $gallery->delete();
        }
        public function DataFormat($galleryInfo){
            $product=$galleryInfo->Product;
            $productInfo=$product->ProductInfo;
            return [
                "id" => $galleryInfo->id ,
                "image" => $galleryInfo->image ,
                "productInfo" => [
                    "code" => $product->code ,
                    "image" => $productInfo->image ,
                    "name" => $productInfo->name
                ] ,
                "updatedAt" => convertDateToFarsi($galleryInfo->updated_at)
            ];
        }
    }
?>
