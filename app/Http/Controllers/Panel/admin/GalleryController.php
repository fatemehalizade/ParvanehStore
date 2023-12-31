<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Gallery\GalleryContract;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private static $galleryClass;
    public function __construct(GalleryContract $galleryContract){
        self::$galleryClass=$galleryContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries=self::$galleryClass->GetAll();
        $galleriesList=[];
        foreach ($galleries as $key => $gallery) {
            $galleriesList[]=self::$galleryClass->DataFormat($gallery);
        }
        return ["status" => 200 , "galleriesList" => $galleriesList];
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
    public function store(GalleryRequest $request)
    {
        self::$galleryClass->Create($request);
        return ["status" => 200 , "message" => "گالری تصویر موادغذایی با موفقیت ثبت شد"];
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
        self::$galleryClass->Delete($id);
        return ["status" => 200 , "message" => "گالری تصویر موادغذایی با موفقیت حذف شد"];
    }
}
