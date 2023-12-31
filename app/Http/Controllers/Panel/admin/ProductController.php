<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product\ProductContract;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private static $productClass,$galleryClass;
    public function __construct(ProductContract $productContract)
    {
        self::$productClass=$productContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsId=self::$productClass->GetAllIds();
        // self::$productClass->GetRowsIds();
        $productsList=[];
        foreach ($productsId as $info => $product) {
            $info=self::$productClass->GetData($product->id);
            $productsList[]=self::$productClass->DataFormat($info["product"],$info["productInfo"]);
        }
        return ["status" => 200 , "productsList" => $productsList];
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
    public function store(ProductRequest $request)
    {
        self::$productClass->Create($request);
        return ["status" => 200 , "message" => "اطلاعات موادغذایی با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productInfo=self::$productClass->GetData($id);
        return ["status" => 200 , "productInfo" => self::$productClass->DataFormat($productInfo["product"],$productInfo["productInfo"])];
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
    public function update(ProductRequest $request, $id)
    {
        self::$productClass->update($request,$id);
        return ["status" => 200 , "message" => "اطلاعات موادغذایی با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$productClass->Delete($id);
        return ["status" => 200 , "message" => "اطلاعات موادغذایی با موفقیت حذف شد"];
    }
}
