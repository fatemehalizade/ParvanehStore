<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Factor\FactorContract;
// use App\User\UserContract;
use App\Order\OrderContract;
use App\Product\ProductContract;
use App\Payment\PaymentContract;

class AdminFactorController extends Controller
{
    private static $factorClass,$productClass,$userClass,$orderClass,$paymentClass;
    public function __construct(FactorContract $factorContract,ProductContract $productContract
        ,OrderContract $orderContract,PaymentContract $paymentContract)
    {
        self::$factorClass=$factorContract;
        self::$productClass=$productContract;
        self::$orderClass=$orderContract;
        self::$paymentClass=$paymentContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factorsList=[];
        $factors=self::$factorClass->GetAll();
        foreach ($factors as $key => $factor) {
            $factorInfo=self::$factorClass->FactorFormat($factor);
            $paymentInfo=[];
            if($factor->status == 2){
                $paymentInfo=self::$paymentClass->PaymentFormat($factor->Payment);
            }
            $orders=$factor->order;
            $ordersList=[];
            foreach ($orders as $key => $order) {
                $ordersList[]=self::$orderClass->OrderFormat($order);
            }
            $factorInfo["orders"]=$ordersList;
            $factorInfo["paymentInfo"]=$paymentInfo;
            $factorsList[]=$factorInfo;
        }
        return ["status" => 200 , "factors" => $factorsList];
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
        //
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
