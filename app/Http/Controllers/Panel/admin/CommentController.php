<?php

namespace App\Http\Controllers\Panel\admin;

use App\Comment\CommentContract;
use App\User\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private static $commentClass,$userClass;
    public function __construct(CommentContract $commentContract,UserContract $userContract){
        self::$commentClass=$commentContract;
        self::$userClass=$userContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=self::$commentClass->CommentsList(1);
        $commentsList=[];
        foreach ($comments as $key => $comment) {
            $commentsList[]=self::$commentClass->DataFormat($comment);
        }
        return ["status" => 200 , "commentsList" => $commentsList];
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
    public function store(CommentRequest $request)
    {
        $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken)[0];
        self::$commentClass->Create($request,$userInfo->id);
        return ["status" => 200 , "message" => "پاسختان با موفقیت ثبت شد"];
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
        if(isset($request->status) && ($request->status == 0 || $request->status == 1)){
            self::$commentClass->DetermineStatus($id,$request->status);
            return ["status" => 200 , "message" => "وضعیت نظر با موفقیت ویرایش شد"];
        }
        else{
            return ["status" => 404 , "message" => "اطلاعات ورودی نامعتبر است"];
        }
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
