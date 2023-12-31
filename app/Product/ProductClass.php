<?php
    namespace App\Product;

    use App\Models\Product;
    use App\Models\Product_info;
    use Illuminate\Http\Request;

    class ProductClass implements ProductContract{
        public function GetRowsIds(){
            return Product::select("id")->orderBy("id","DESC")->paginate(10);
        }
        public function GetAllIds(){
            return Product::orderBy("id","DESC")->get(["id"]);
        }
        public function GetData($id){
            $productInfo=null;
            $product=Product::where("id",$id)->first();
            if($product){
                $productInfo=$product->ProductInfo;
            }
            return ["product" => $product,"productInfo" => $productInfo];
        }
        public function GetProductByBrand($brandId){
            return Product_info::where("brand_id",$brandId)->orderBy("id","DESC")->get();
        }
        public function GetProductByCategory($categoryId){
            return Product_info::where("category_id",$categoryId)->orderBy("id","DESC")->get();
        }
        public function Create(Request $request){
            $product=new Product();
            $product->code=rand(100000,999999);
            $product->count=$request->count;
            $product->price=$request->price;
            $product->save();
            $productInfo=new Product_info();
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                $newName=md5(time()).".".$imageInfo->getClientOriginalExtension();
                $productInfo->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $productInfo->name=$request->productName;
            $productInfo->weight=$request->weight;
            $productInfo->health_licence_number=$request->healthLicenceNumber;
            $productInfo->category_id=$request->categoryId;
            $productInfo->brand_id=$request->brandId;
            $productInfo->package_type_id=$request->packageTypeId;
            $productInfo->producer_id=$request->producerId;
            $productInfo->product_id=$product->id;
            $productInfo->description=$request->description;
            $tagNameString="";
            $tagIds=[];
            foreach (\json_decode($request->tags,true) as $tagId => $tagName) {
                $tagNameString .= $tagName." ";
                $tagIds[]=$tagId;
            }
            $product->Tag()->sync($tagIds);
            $productInfo->tags=$tagNameString;
            $productInfo->save();
        }
        public function Update(Request $request,$id){
            $infos=$this->GetData($id);
            $product=$infos["product"];
            $productInfo=$infos["productInfo"];
            $product->count=$request->count;
            $product->price=$request->price;
            $imageInfo=$request->file("image");
            if(!is_null($imageInfo)){
                if($productInfo && $productInfo->image){
                    unlink("storage/".$productInfo->image);
                }
                $newName=md5(time()).".".$imageInfo->getClientOrginalExtension();
                $productInfo->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $productInfo->name=$request->productName;
            $productInfo->health_licence_number=$request->healthLicenceNumber;
            $productInfo->weight=$request->weight;
            $productInfo->category_id=$request->categoryId;
            $productInfo->brand_id=$request->brandId;
            $productInfo->producer_id=$request->producerId;
            $productInfo->package_type_id=$request->packageTypeId;
            $productInfo->description=$request->description;
            $tagNameString="";
            $tagIds=[];
            foreach ($request->tags as $tagId => $tagName) {
                $tagNameString .= $tagName." ";
                $tagIds[]=$tagId;
            }
            if(trim($tagNameString) != trim($productInfo->tags)){
                $product->Tag()->sync($tagIds);
                $productInfo->tags=$tagNameString;
            }
            $product->updated_at=date("Y-m-d H:i:s");
            $productInfo->updated_at=date("Y-m-d H:i:s");
            $product->save();
            $productInfo->save();
        }
        public function UpdateProductCount($productCount,$id){
            $infos=$this->GetData($id);
            $product=$infos["product"];
            $product->count -=$productCount;
            $product->updated_at=date("Y-m-d H:i:s");
            $product->save();
        }
        public function Delete($id){
            $product=$this->GetData($id);
            if($product["productInfo"] && $product["productInfo"]->image){
                unlink("storage/".$product["productInfo"]->image);
            }
            $product["product"]->delete();
        }
        public function SearchProducts(Request $request){
            if($request->searchText != null && $request->categoriesList != null && $request->brandsList != null){
                return Product_info::where(function($query){
                    $query->where("name","like",'%'.$request->searchText.'%')->orWhere("tags","like",'%'.$request->searchText.'%');
                })->whereIn("category_id",explode(",",$request->categoriesList))->whereIn("brand_id",explode(",",$request->brandsList))->get()->product_id;
            }
            else if($request->searchText != null && $request->brandsList != null && $request->categoriesList == null){
                return Product_info::where(function($query){
                    $query->where("name","like",'%'.$request->searchText.'%')->orWhere("tags","like",'%'.$request->searchText.'%');
                })->whereIn("brand_id",explode(",",$request->brandsList))->get();
            }
            else if($request->searchText != null && $request->categoriesList != null && $request->brandsList == null){
                return Product_info::where(function($query){
                    $query->where("name","like",'%'.$request->searchText.'%')->orWhere("tags","like",'%'.$request->searchText.'%');
                })->whereIn("category_id",explode(",",$request->categoriesList))->get();
            }
            else if($request->brandsList != null && $request->categoriesList != null && $request->searchText == null){
                return Product_info::whereIn("brand_id",explode(",",$request->brandsList))->whereIn("category_id",explode(",",$request->categoriesList))->get();
            }
            else if($request->searchText != null && $request->categoriesList == null && $request->brandsList == null){
                return Product_info::where("name","like",'%'.$request->searchText.'%')->orWhere("tags","like",'%'.$request->searchText.'%')->get();
            }
            else if($request->categoriesList != null && $request->searchText == null && $request->brandsList == null){
                return Product_info::whereIn("category_id",explode(",",$request->categoriesList))->get();
            }
            else if($request->brandsList != null && $request->searchText == null && $request->categoriesList == null){
                return Product_info::whereIn("brand_id",explode(",",$request->brandsList))->get();
            }
        }
        public function DataFormat($product,$productInfo){
            return [
                "id"=>$product->id,
                "code"=>$product->code,
                "count"=>$product->count,
                "price"=>$product->price,
                "healthLicenceNumber"=> $productInfo ? $productInfo->health_licence_number : null,
                "image"=> $productInfo ? $productInfo->image : null,
                "productName"=> $productInfo ? $productInfo->name : null,
                "categoryInfo"=> $productInfo ? ($productInfo->category_id ? ["id"=>$productInfo->category_id,"name"=>$productInfo->Category->name,"nickName"=>$productInfo->Category->nick_name] : null) : null,
                "barndInfo"=> $productInfo ? ($productInfo->brand_id ? ["id"=>$productInfo->brand_id,"name"=>$productInfo->Brand->brand,"image"=>$productInfo->Brand->image] : null) : null,
                "packageTypeInfo"=> $productInfo ? ($productInfo->package_type_id ? ["id"=>$productInfo->package_type_id,"name"=>$productInfo->PackageType->type] : null) : null,
                "producerInfo"=> $productInfo ? ($productInfo->producer_id ? ["id"=>$productInfo->producer_id,"name"=>$productInfo->Producer->producer,"image"=>$productInfo->Producer->image] : null) : null,
                "weight"=>$productInfo ? $productInfo->weight : null,
                "tags"=>$productInfo ? $productInfo->tags : null,
                "description"=> $productInfo ? $productInfo->description : null,
                "updatedAt"=>convertDateToFarsi($product->updated_at)
            ];
        }
    }
    ?>
