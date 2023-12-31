<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\Panel\Tag;
use App\Tag\TagContract;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private static $tagClass;
    public function __construct(TagContract $tagContract)
    {
        self::$tagClass=$tagContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags=self::$tagClass->GetAll();
        // self::$tagClass->GetRows();
        $tagsList=[];
        foreach ($tags as $key => $tag) {
            $tagsList[]=new Tag($tag);
        }
        return ["status" => 200 , "tagsList" => $tagsList];
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
    public function store(TagRequest $request)
    {
        self::$tagClass->Create($request);
        return ["status" => 200 , "message" => "برچسب با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tagInfo=self::$tagClass->GetData($id);
        return ["status" => 200 , "tagInfo" => new Tag($tagInfo)];
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
    public function update(TagRequest $request, $id)
    {
        self::$tagClass->Update($request,$id);
        return ["status" => 200 , "message" => "برچسب با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$tagClass->Delete($id);
        return ["status" => 200 , "message" => "برچسب با موفقیت حذف شد"];
    }
}
