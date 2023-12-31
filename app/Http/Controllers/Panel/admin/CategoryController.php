<?php

namespace App\Http\Controllers\Panel\admin;

use App\Category\CategoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Panel\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private static $categoryClass;
    public function __construct(CategoryContract $categoryContract)
    {
        self::$categoryClass=$categoryContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=self::$categoryClass->CategoryList();
        $categoriesList=[];
        foreach ($categories as $key => $category) {
            $categoriesList[]=new Category($category);
        }
        return ["status" => 200 , "categoriesList" => $categoriesList];
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
    public function store(CategoryRequest $request)
    {
        self::$categoryClass->Create($request);
        return ["status" => 200 , "message" => "دسته موادغذایی با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoryInfo=self::$categoryClass->GetData($id);
        return ["status" => 200 , "categoryInfo" => new Category($categoryInfo)];
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
    public function update(CategoryRequest $request, $id)
    {
        self::$categoryClass->Update($request,$id);
        return ["status" => 200 , "message" => "دسته موادغذایی با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$categoryClass->Delete($id);
        return ["status" => 200 , "message" => "دسته موادغذایی با موفقیت حذف شد"];
    }
}
