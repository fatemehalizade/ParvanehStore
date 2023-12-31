<?php

namespace App\Http\Controllers\Panel\admin;

use App\Discount\DiscountContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    private static $discountClass;
    public function __construct(DiscountContract $discountContract){
        self::$discountClass=$discountContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts=self::$discountClass->GetAll();
        // self::$discountClass->GetRows();
        $discountsList=[];
        foreach ($discounts as $key => $discount) {
            $discountsList[]=self::$discountClass->DataFormat($discount);
        }
        return ["status" => 200 , "discountsList" => $discountsList];
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
    public function store(DiscountRequest $request)
    {
        self::$discountClass->Create($request);
        return ["status" => 200 , "message" => "تخفیف موادغذایی با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discountInfo=self::$discountClass->GetData($id);
        return ["status" => 200 , "discountInfo" => self::$discountClass->DataFormat($discountInfo)];
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
    public function update(DiscountRequest $request, $id)
    {
        self::$discountClass->Update($request,$id);
        return ["status" => 200 , "message" => "تخفیف موادغذایی با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$discountClass->Delete($id);
        return ["status" => 200 , "message" => "تخفیف موادغذایی با موفقیت حذف شد"];
    }
}
