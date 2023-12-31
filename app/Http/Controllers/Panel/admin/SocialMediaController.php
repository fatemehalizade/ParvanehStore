<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\SocialMedia\SocialMediaContract;
use App\Http\Requests\SocialMediaRequest;
use App\Http\Resources\Panel\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    private static $socialMediaClass;
    public function __construct(SocialMediaContract $socialMediaContract){
        self::$socialMediaClass=$socialMediaContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias=self::$socialMediaClass->GetAll();
        $socialMediasList=[];
        foreach ($medias as $key => $media) {
            $socialMediasList[]=new SocialMedia($media);
        }
        return ["status" => 200 , "socialMediasList" => $socialMediasList];
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
    public function store(SocialMediaRequest $request)
    {
        self::$socialMediaClass->Create($request);
        return ["status" => 200 , "message" => "اطلاعات شبکه اجتماعی با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mediaInfo=self::$socialMediaClass->GetData($id);
        return ["status" => 200 , "socialMediaInfo" => new SocialMedia($mediaInfo)];
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
    public function update(SocialMediaRequest $request, $id)
    {
        self::$socialMediaClass->Update($request,$id);
        return ["status" => 200 , "message" => "اطلاعات شبکه اجتماعی با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$socialMediaClass->Delete($id);
        return ["status" => 200 , "message" => "اطلاعات شبکه اجتماعی با موفقیت حذف شد"];
    }
}
