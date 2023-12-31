<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Order\OrderContract;
use App\Product\ProductContract;
use App\User\UserContract;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private static $orderClass,$productClass,$userClass;
    public function __construct(OrderContract $orderContract,ProductContract $productContract,UserContract $userContract)
    {
        self::$orderClass=$orderContract;
        self::$productClass=$productContract;
        self::$userClass=$userContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allOrders=self::$orderClass->GetRows();
        $completedOrders=[];
        foreach ($allOrders as $key => $order) {
            $completedOrders[]=self::$orderClass->OrderFormat($order);
        }
        return ["status" => 200 , "completedOrders" => $completedOrders];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->APItoken) && !empty($request->APItoken)){
            $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
            if(count($userInfo) != 0){
                $productInfo=self::$productClass->GetData($request->productId);
                $percent=0;
                $productOff=$productInfo["product"]->Discount;
                if(!is_null($productOff)){
                    $date=date("Y-m-d H:i:s");
                    if($productOff->start <= $date && $productOff->finish >= $date){
                        $percent=$productOff->percent;
                    }
                }
                $price=$productInfo["product"]->price * $request->productCount;
                $offPrice=$price*($percent/100);
                $totalPrice=$price - $offPrice;
                $infos=["productId" => $request->productId ,
                "productCount" => $request->productCount ,
                "off" => $percent ,
                "totalPrice" => $totalPrice ,
                "userId" => $userInfo[0]->id];
                self::$orderClass->Create($infos);
                return ["status" => 200 , "message" => "محصول با موفقیت به سبدخرید افزوده شد"];
            }
            return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای افزودن محصول به سبدخرید ، ابتدا وارد پنل کاربریتان شوید"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
