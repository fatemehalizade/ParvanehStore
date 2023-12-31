<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Factor\FactorContract;
use App\User\UserContract;
use App\Order\OrderContract;
use App\Payment\PaymentContract;

class PaymentController extends Controller
{
    private static $paymentClass,$userClass,$factorClass,$orderClass;
    public function __construct(FactorContract $factorContract,OrderContract $orderContract,PaymentContract $paymentContract,UserContract $userContract)
    {
        self::$paymentClass=$paymentContract;
        self::$factorClass=$factorContract;
        self::$userClass=$userContract;
        self::$orderClass=$orderContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
                self::$paymentClass->Create($request);
                $orders=self::$orderClass->GetOrders($userInfo[0]->id,1);
                foreach ($orders as $key => $order) {
                    self::$orderClass->UpdateStatus($order->id,2);
                }
                self::$factorClass->UpdateStatus($request->factorId,2);
                return ["status" => 200 , "message" => "پرداخت فاکتور با موفقیت انجام شد"];
            }
            return ["status" => 400 , "message" => "برای پرداخت فاکتور ، ابتدا وارد پنل کاربریتان شوید"];
        }
        else{
            return ["status" => 400 , "message" => "برای پرداخت فاکتور ، ابتدا وارد پنل کاربریتان شوید"];
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
