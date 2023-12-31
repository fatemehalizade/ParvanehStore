<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageTypeRequest;
use App\Http\Resources\Panel\PackageType;
use App\PackageType\PackageTypeContract;
use Illuminate\Http\Request;

class PackageTypeController extends Controller
{
    private static $packageTypeClass;
    public function __construct(PackageTypeContract $packageTypeContract)
    {
        self::$packageTypeClass=$packageTypeContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packageTypes=self::$packageTypeClass->GetAll();
        // self::$packageTypeClass->GetRows();
        $packageTypesList=[];
        foreach ($packageTypes as $key => $packageType) {
            $packageTypesList[]=new PackageType($packageType);
        }
        return ["status" => 200 , "packageTypesList" => $packageTypesList];
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
    public function store(PackageTypeRequest $request)
    {
        self::$packageTypeClass->Create($request);
        return ["status" => 200 , "message" => "نوع بسته بندی موادغذایی با موفقیت ثبت شد "];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $packageTypeInfo=self::$packageTypeClass->GetData($id);
        return ["status" => 200 , "packageTypeInfo" => new PackageType($packageTypeInfo)];
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
    public function update(PackageTypeRequest $request, $id)
    {
        self::$packageTypeClass->Update($request,$id);
        return ["status" => 200 , "message" => "نوع بسته بندی موادغذایی با موفقیت ویرایش شد "];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$packageTypeClass->Delete($id);
        return ["status" => 200 , "message" => "نوع بسته بندی موادغذایی با موفقیت حذف شد "];
    }
}
