<?php

namespace App\Http\Controllers\UserPages;

use App\Http\Controllers\Controller;
use  App\ContactUs\ContactContract;
use App\Http\Requests\ContactUsRequest;
use App\User\UserContract;
use App\Profile\ProfileContract;
use App\Http\Resources\Panel\Profile;
use App\SocialMedia\SocialMediaContract;
use App\Http\Resources\Panel\SocialMedia;
use App\Order\OrderContract;
use App\Product\ProductContract;
use App\Factor\FactorContract;
use App\Payment\PaymentContract;
use App\Category\CategoryContract;
use App\Http\Resources\Panel\Category;
use App\Brand\BrandContract;
use App\Http\Resources\Panel\Brand;
use App\Discount\DiscountContract;
use App\Score\ScoreContract;
use App\Comment\CommentContract;
use App\Like\LikeContract;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private static $contactClass,$profileClass,$userClass,$socialMediaClass,$factorClass,$paymentClass,$categoryClass,$brandClass,
        $discountClass,$scoreClass,$orderClass,$productClass,$commentClass,$likeClass;
    public function __construct(ContactContract $contactContract,ProfileContract $profileContract,SocialMediaContract $socialMediaContract,
        OrderContract $orderContract,ProductContract $productContract,FactorContract $factorContract,PaymentContract $paymentContract,UserContract $userContract,
        CategoryContract $categoryContract,BrandContract $brandContract,DiscountContract $discountContract,ScoreContract $scoreContract,
        CommentContract $commentContract,LikeContract $likeContract){
        self::$contactClass=$contactContract;
        self::$profileClass=$profileContract;
        self::$userClass=$userContract;
        self::$socialMediaClass=$socialMediaContract;
        self::$orderClass=$orderContract;
        self::$productClass=$productContract;
        self::$factorClass=$factorContract;
        self::$paymentClass=$paymentContract;
        self::$categoryClass=$categoryContract;
        self::$brandClass=$brandContract;
        self::$discountClass=$discountContract;
        self::$scoreClass=$scoreContract;
        self::$commentClass=$commentContract;
        self::$likeClass=$likeContract;
    }
    public function Categories(){
        $categories=self::$categoryClass->CategoryList();
        $categoriesList=[];
        foreach ($categories as $key => $category) {
            $categoriesList[]=new Category($category);
        }
        return ["status" => 200 , "categoriesList" => $categoriesList];
    }
    public function Brands(){
        $brands=self::$brandClass->GetAll();
        // self::$brandClass->GetRows();
        $brandsList=[];
        foreach ($brands as $key => $brand) {
            $brandsList[]=new Brand($brand);
        }
        return ["status" => 200 , "brandsList" => $brandsList];
    }
    public function Products(){
        $productsId=self::$productClass->GetAllIds();
        // self::$productClass->GetRowsIds();
        $productsList=[];
        foreach ($productsId as $info => $product) {
            $info=self::$productClass->GetData($product->id);
            $percent=0;
            $discountInfo=$info["product"]->Discount;
            if($discountInfo != null){
                $date=date("Y-m-d H:i:s");
                if($discountInfo->start <= $date && $discountInfo->finish >= $date){
                    $percent=$discountInfo->percent;
                }
            }
            $productFormat=self::$productClass->DataFormat($info["product"],$info["productInfo"]);
            $productFormat["off"]=$percent;
            $productsList[]=$productFormat;
        }
        return ["status" => 200 , "productsList" => $productsList];
    }
    public function Discounts(){
        $discounts=self::$discountClass->GetAll();
        // self::$discountClass->GetRows();
        $discountsList=[];
        foreach ($discounts as $key => $discount) {
            $date=date("Y-m-d H:i:s");
            if($discount->start <= $date && $discount->finish >= $date){
                $discountsList[]=self::$discountClass->DataFormat($discount);
            }
        }
        return ["status" => 200 , "discountsList" => $discountsList];
    }
    public function MoreScoreProduct(){
        $moreScoreProductsList=[];
        $scores=[];
        $products=self::$productClass->GetAllIds();
        foreach ($products as $key => $product) {
            $scores[$product->id]=self::$scoreClass->GetScore($product->id);
        }
        arsort($scores);
        foreach ($scores as $key => $score) {
            $productInfo=self::$productClass->GetData($key);
            $productAllInfo=self::$productClass->DataFormat($productInfo["product"],$productInfo["productInfo"]);
            $productAllInfo["score"]=$score;
            $moreScoreProductsList[]=$productAllInfo;
        }
        return ["status" => 200 , "moreScoreProductsList" => $moreScoreProductsList];
    }
    public function CreateContactUs(ContactUsRequest $request){
        self::$contactClass->Create($request);
        return ["status" => 200 , "message" => "نظرتان با موفقیت ثبت شد"];
    }
    public function StoreProfile(){
        $profileInfo=self::$profileClass->GetData();
        return ["status" => 200 , "profileInfo" => new Profile($profileInfo)];
    }
    public function SocialMedias(){
        $medias=self::$socialMediaClass->GetAll();
        $socialMediasList=[];
        foreach ($medias as $key => $media) {
            $socialMediasList[]=new SocialMedia($media);
        }
        return ["status" => 200 , "socialMediasList" => $socialMediasList];
    }
    public function RedusOrder(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    $orderInfo=self::$orderClass->GetOrder($request->productId,$userInfo[0]->id,0);
                    if(count($orderInfo) != 0){
                        $newOrder=self::$orderClass->Delete($orderInfo[0]->id);
                        return ["status" => 200 , "newOrder" => self::$orderClass->OrderFormat($newOrder) , "message" => "محصول با موفقیت از سبدخرید حذف شد"];
                    }
                    return ["status" => 400 , "message" => "برای حذف محصول از سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
                }
                return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای حذف محصول از سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای حذف محصول از سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function CreateOrder(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    $orderInfo=self::$orderClass->GetOrder($request->productId,$userInfo[0]->id,0);
                    $productInfo=self::$productClass->GetData($request->productId);
                    if(count($orderInfo) != 0){
                        if($orderInfo[0]->product_count+1 <= $productInfo["product"]->count){
                            $newOrder=self::$orderClass->Add($orderInfo[0]->id);
                            return ["status" => 200 , "newOrder" => self::$orderClass->OrderFormat($newOrder) , "message" => "محصول با موفقیت به سبدخرید افزوده شد"];
                        }
                        else{
                            return ["status" => 400 , "message" => "تعداد محصول درخواستی شما ، بیش از موجودی محصول در انبار ما می باشد"];
                        }
                    }
                    else{
                        $percent=0;
                        $productOff=$productInfo["product"]->Discount;
                        if(!is_null($productOff)){
                            $date=date("Y-m-d H:i:s");
                            if($productOff->start <= $date && $productOff->finish >= $date){
                                $percent=$productOff->percent;
                            }
                        }
                        // $price=$productInfo["product"]->price * $request->productCount;
                        $offPrice=$productInfo["product"]->price * ($percent/100);
                        $totalPrice=$productInfo["product"]->price - $offPrice;
                        $infos=["productId" => $request->productId ,
                        // "productCount" => $request->productCount ,
                        "off" => $percent ,
                        "totalPrice" => $totalPrice ,
                        "userId" => $userInfo[0]->id];
                        self::$orderClass->Create($infos);
                    }
                    return ["status" => 200 , "message" => "محصول با موفقیت به سبدخرید افزوده شد"];
                }
                return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function UserBasket(Request $request){
        if(isset($request->APItoken)){
            if(!empty($request->APItoken)){
                $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
                if(count($userInfo) != 0){
                    $orders=self::$orderClass->GetOrders($userInfo[0]->id,0);
                    $fullPrice=0;
                    $ordersList=[];
                    foreach ($orders as $key => $order) {
                        $ordersList[]=self::$orderClass->OrderFormat($order);
                        $fullPrice += $order->price;
                    }
                    return ["status" => 200 , "ordersInfo" => $ordersList,"fullPrice" => $fullPrice];
                }
            }
            return ["status" => 400 , "message" => "برای مشاهده سبدخریدتان ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای مشاهده سبدخریدتان ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function CreateFactor(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                $orders=self::$orderClass->GetOrders($userInfo[0]->id,0);
                $factorInfo=[];
                $allPrice=0;
                if(count($orders) == 0){
                    $factor=self::$factorClass->GetUserEnableFactor($userInfo[0]->id)[0];
                    $orders=$factor->Order;
                }
                else if(count($orders[0]->Factor) == 0){
                    $factor=self::$factorClass->Create($userInfo[0]->id);
                }
                $factorInfo=self::$factorClass->FactorFormat($factor);
                $ordersList=[];
                foreach ($orders as $key => $order) {
                    $allPrice += $order->price;
                    $ordersList[]=self::$orderClass->OrderFormat($order);
                    if(count($orders[0]->Factor) == 0){
                        self::$orderClass->UpdateStatus($order->id,1);
                        $factor->Order()->attach($order->id);
                    }
                }
                $factorInfo["orders"]=$ordersList;
                $factorInfo["allPrice"]=$allPrice;
                return ["status" => 200 , "factorInfo" => $factorInfo];
            }
            return ["status" => 400 , "message" => "برای تکمیل خرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای تکمیل خرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function CreatePayment(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                $payment=self::$paymentClass->Create($request);
                $paymentInfo=self::$paymentClass->PaymentFormat($payment);
                $orders=self::$orderClass->GetOrders($userInfo[0]->id,1);
                foreach ($orders as $key => $order) {
                    self::$orderClass->UpdateStatus($order->id,2);
                    self::$productClass->UpdateProductCount($order->product_count,$order->product_id);
                }
                self::$factorClass->UpdateStatus($request->factorId,2);
                return ["status" => 200 , "paymentInfo" => $paymentInfo , "message" => "پرداخت فاکتور با موفقیت انجام شد"];
            }
            return ["status" => 400 , "message" => "برای پرداخت فاکتور ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای پرداخت فاکتور ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function SearchProducts(Request $request){
        if($request->searchText == null && $request->brandsList == null && $request->categoriesList == null){
            return ["status" => 400 , "message" =>  "فیلتری را برای جستجو انتخاب کنید"];
        }
        else{
            $searchInfo=self::$productClass->SearchProducts($request);
            if(count($searchInfo) != 0){
                $productsList=[];
                foreach ($searchInfo as $key => $productINFO) {
                    $info=self::$productClass->GetData($productINFO->product_id);
                    $percent=0;
                    $discountInfo=$info["product"]->Discount;
                    if($discountInfo != null){
                        $date=date("Y-m-d H:i:s");
                        if($discountInfo->start <= $date && $discountInfo->finish >= $date){
                            $percent=$discountInfo->percent;
                        }
                    }
                    $productFormat=self::$productClass->DataFormat($info["product"],$info["productInfo"]);
                    $productFormat["off"]=$percent;
                    $productsList[]=$productFormat;
                }
                return ["status" => 200 , "searchResult" => $productsList];
            }
            else{
                return ["status" => 400 , "message" => "نتیجه ای یافت نشد"];
            }
        }
    }
    public function ProductComments($id){
        $comments=self::$commentClass->CommentsList(0,$id);
        if(count($comments) != 0){
            $commentsList=[];
            foreach ($comments as $key => $comment) {
                $commentsList[]=self::$commentClass->DataFormat($comment);
            }
            return ["status" => 200 , "commentsList" => $commentsList];
        }
        return ["status" => 400 , "message" => "تاکنون کامنتی ثبت نشده است"];
    }
    public function CreateComment(CommentRequest $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId) && $request->productId){
                    $productInfo=self::$productClass->GetData($request->productId);
                    if($productInfo["product"]){
                        self::$commentClass->Create($request,$userInfo[0]->id);
                        return ["status" => 200 , "message" => "نظرتان با موفقیت ثبت شد"];
                    }
                    return ["status" => 400 , "message" => "برای ثبت کامنت محصول ، محصول موردنظرتان را انتخاب کنید"];
                }
                return ["status" => 400 , "message" => "برای ثبت کامنت محصول ، محصول موردنظرتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای ثبت کامنت محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای ثبت کامنت محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function CreateScore(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    self::$scoreClass->Create($request,$userInfo[0]->id);
                    $scoreInfo=self::$scoreClass->GetScore($request->productId);
                    return ["status" => 200 , "productScore" => $scoreInfo , "message" => "امتیاز محصول با موفقیت ثبت شد"];
                }
                return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function UserScore(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    $scoreInfo=self::$scoreClass->CheckUser($userInfo[0]->id,$request->productId);
                    $info=[];
                    if(\count($scoreInfo) != 0){
                        $info=self::$scoreClass->ScoreFormat($scoreInfo[0]);
                    }
                    return ["status" => 200 , "userScoreInfo" => $info];
                }
                return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای ثبت امتیاز محصول ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function CreateLike(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    $productLikeInfo=self::$likeClass->GetData($request->productId);
                    if(count($productLikeInfo) == 0){
                        self::$likeClass->Create($request->productId);
                        self::$likeClass->LikeUpdate($request->productId,$userInfo[0]->id);
                        $LikeInfo=self::$likeClass->GetData($request->productId);
                        return ["status" => 200 , "productLikeInfo" => self::$likeClass->LikeFormat($LikeInfo)];
                    }
                    else{
                        $userLike=self::$likeClass->CheckUserLike($userInfo[0]->id);
                        if(count($userLike) == 0){
                            self::$likeClass->LikeUpdate($request->productId,$userInfo[0]->id);
                        }
                        $LikeInfo=self::$likeClass->GetData($request->productId);
                        return ["status" => 200 , "productLikeInfo" => self::$likeClass->LikeFormat($LikeInfo)];
                    }
                }
                return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function UserLike(Request $request){
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                if(isset($request->productId)){
                    $likeInfo=self::$likeClass->GetData($request->productId);
                    if(\count($likeInfo) != 0){
                        $userLikeInfo=self::$likeClass->GetUserLike($userInfo[0]->id,$likeInfo[0]->id);
                        $info=[];
                        if(count($userLikeInfo) != 0){
                            $info=self::$likeClass->LikeFormat([$userLikeInfo[0]->Like]);
                        }
                        return ["status" => 200 , "productLikeInfo" => $info];
                    }
                    return ["status" => 400 , "message" => "عدم اطلاعات علاقه مندی برای کاربر موردنظر"];
                }
                return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، محصولتان را انتخاب کنید"];
            }
            return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای ثبت محصول به علاقه مندی ها ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }
    public function ProductDetail($id){
        $info=self::$productClass->GetData($id);
        $percent=0;
        $discountInfo=$info["product"]->Discount;
        if($discountInfo != null){
            $date=date("Y-m-d H:i:s");
            if($discountInfo->start <= $date && $discountInfo->finish >= $date){
                $percent=$discountInfo->percent;
            }
        }
        $productDetail=self::$productClass->DataFormat($info["product"],$info["productInfo"]);
        $productDetail["off"]=$percent;
        $like=0;
        $likeInfo=$info["product"]->Like;
        if(isset($likeInfo)){
            if(\count($likeInfo) != 0){
                $like=$likeInfo[0]->count;
            }
        }
        $productDetail["like"]=$like;
        $score=self::$scoreClass->GetScore($id);
        $productDetail["score"]=$score;
        $galleries=$info["product"]->Gallery;
        $galleriesList=[];
        foreach ($galleries as $key => $gallery) {
            $galleriesList[]=$gallery->image;
        }
        $productDetail["galleries"]=$galleriesList;
        return ["status" => 200 , "productDetail" => $productDetail];
    }
    public function GetProductByBrand($id){
        $productBrands=self::$productClass->GetProductByBrand($id);
        $brandsList=[];
        foreach ($productBrands as $key => $productBrand) {
            $info=self::$productClass->GetData($productBrand->product_id);
            $percent=0;
            $discountInfo=$info["product"]->Discount;
            if($discountInfo != null){
                $date=date("Y-m-d H:i:s");
                if($discountInfo->start <= $date && $discountInfo->finish >= $date){
                    $percent=$discountInfo->percent;
                }
            }
            $productFormat=self::$productClass->DataFormat($info["product"],$info["productInfo"]);
            $productFormat["off"]=$percent;
            $brandsList[]=$productFormat;
        }
        return ["status" => 200 , "productsBrandList" => $brandsList];
    }
    public function GetProductByCategory($id){
        $productsList=[];
        $CategoriesList=self::$categoryClass->CategoryList($id);
        foreach ($CategoriesList as $key => $category) {
            $info=self::$productClass->GetProductByCategory($category->id);
            if(count($info) != 0){
                $newInfo=self::$productClass->GetData($info[0]->product_id);
                $percent=0;
                $discountInfo=$newInfo["product"]->Discount;
                if($discountInfo != null){
                    $date=date("Y-m-d H:i:s");
                    if($discountInfo->start <= $date && $discountInfo->finish >= $date){
                        $percent=$discountInfo->percent;
                    }
                }
                $productFormat=self::$productClass->DataFormat($newInfo["product"],$newInfo["productInfo"]);
                $productFormat["off"]=$percent;
                $productsList[]=$productFormat;
            }
        }
        return ["status" => 200 , "productsCategoryList" => $productsList];
    }
}
