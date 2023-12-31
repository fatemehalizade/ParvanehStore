<?php
    namespace App\Category;

    use App\Models\Category;
    use Illuminate\Http\Request;

    class CategoryClass implements CategoryContract{
        private static $categoriesList;
        public function GetRows($categoryId=0,$level=1){
            return Category::where("category_id",$categoryId)->where("level",$level)->orderBy("id","DESC")->get();
        }
        public function SubCategoriesList($categoryInfo){
            $subCategories=$this->GetRows($categoryInfo->id,$categoryInfo->level+1);
            if(count($subCategories) != 0){
                foreach ($subCategories as $key => $subCategory) {
                    $categoryIdInfo=$this->GetData($subCategory->category_id);
                    $subCategory["category_id_name"]=$categoryIdInfo->name;
                    self::$categoriesList[]=$subCategory;
                    $this->SubCategoriesList($subCategory);
                }
            }
            return [];
        }
        public function CategoryList($categoryId=0){
            $categoryId != 0 ? $firstLevelCategories=[$this->GetData($categoryId)] : $firstLevelCategories=$this->GetRows();
            if(count($firstLevelCategories) != 0){
                if($firstLevelCategories[0] != null){
                    foreach ($firstLevelCategories as $key => $firstLevelCategory) {
                        self::$categoriesList[]=$firstLevelCategory;
                        $subCategories=$this->SubCategoriesList($firstLevelCategory);
                        if(count($subCategories) != 0){
                            self::$categoriesList[]=$subCategories;
                        }
                    }
                    return self::$categoriesList;
                }
                return [];
            }
            return [];
        }
        public function GetData($id){
            return Category::where("id",$id)->first();
        }
        public function Create(Request $request){
            $category=new Category();
            $category->name=$request->categoryName;
            $category->nick_name=$request->categoryNickName;
            if($request->categoryId != 0){
                $category->category_id=$request->categoryId;
                $category->level=$this->GetData($request->categoryId)->level+1;
            }
            else if($request->categoryId == 0){
                $imageInfo=$request->file("image");
                $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
                $category->image=$imageInfo->storeAs("upload",$newName,"public");
            }
            $category->save();
        }
        public function Update(Request $request,$id){
            $category=$this->GetData($id);
            $category->name=$request->categoryName;
            $category->nick_name=$request->categoryNickName;
            if($category->category_id == 0){
                if($category->category_id == $request->CategoryId){
                    $imageInfo=$request->file("image");
                    if(!is_null($imageInfo)){
                        unlink("storage/".$category->image);
                        $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
                        $category->image=$imageInfo->storeAs("upload",$newName,"public");
                    }
                }
                else{ //$category->category_id != $request->CategoryId
                    unlink("storage/".$category->image);
                    $category->image=null;
                    $category->category_id=$request->categoryId;
                    $category->level=$this->GetData($request->categoryId)->level+1;
                }
            }
            else{
                if($request->CategoryId == 0){
                    $category->category_id=0;
                    $category->level=1;
                    $imageInfo=$request->file("image");
                    $newName=md5(time())."_".rand(100000,999999).".".$imageInfo->getClientOriginalExtension();
                    $category->image=$imageInfo->storeAs("upload",$newName,"public");
                }
                else{ //$category->category_id != $request->CategoryId
                    $category->category_id=$request->categoryId;
                    $category->level=$this->GetData($request->categoryId)->level+1;
                }
            }
            $category->updated_at=date("Y-m-d H:i:s");
            $category->save();
        }
        public function Delete($id){
            $category=$this->GetData($id);
            if(!is_null($category->image)){
                unlink("storage/".$category->image);
            }
            $category->delete();
        }
    }
?>
