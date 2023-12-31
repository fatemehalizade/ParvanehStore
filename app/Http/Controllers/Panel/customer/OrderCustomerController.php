<?php

namespace App\Http\Controllers\Panel\customer;

use App\Http\Controllers\Controller;
use App\Order\OrderContract;
use App\User\UserContract;
use Illuminate\Http\Request;

class OrderCustomerController extends Controller
{
    private static $orderClass,$userClass;
    public function __construct(OrderContract $orderContract,UserContract $userContract)
    {
        self::$orderClass=$orderContract;
        self::$userClass=$userContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken)[0];
        $orders=self::$orderClass->GetOrders($userInfo->id,0);
        $ordersList=[];
        foreach ($orders as $key => $order) {
            $ordersList[]=self::$orderClass->OrderFormat($order);
        }
        return ["status" => 200 , "ordersInfo" => $ordersList];
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
        self::$orderClass->Delete($id);
        return ["status" => 200 , "message" => "حذف شده"];
    }
}
