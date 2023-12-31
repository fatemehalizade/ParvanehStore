<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Factor\FactorContract;
use App\User\UserContract;
use App\Order\OrderContract;
use App\Product\ProductContract;

class FactorController extends Controller
{
    private static $factorClass,$productClass,$userClass,$orderClass;
    public function __construct(FactorContract $factorContract,ProductContract $productContract,
        UserContract $userContract,OrderContract $orderContract)
    {
        self::$factorClass=$factorContract;
        self::$productClass=$productContract;
        self::$userClass=$userContract;
        self::$orderClass=$orderContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
                $factorInfo=[];
                $allPrice=0;
                $factor=self::$factorClass->Create($userInfo[0]->id);
                $factorInfo=self::$factorClass->FactorFormat($factor);
                $orders=self::$orderClass->GetOrders($userInfo[0]->id,0);
                $ordersList=[];
                foreach ($orders as $key => $order) {
                    self::$orderClass->UpdateStatus($order->id,1);
                    $allPrice += $order->price;
                    $ordersList[]=self::$orderClass->OrderFormat($order);
                    $factor->Order()->attach($order->id);
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
