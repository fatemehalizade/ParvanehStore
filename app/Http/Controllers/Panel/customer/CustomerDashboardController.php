<?php

namespace App\Http\Controllers\Panel\customer;

use App\Http\Controllers\Controller;
use App\User\UserContract;
use App\Product\ProductContract;
use App\Like\LikeContract;
use App\Comment\CommentContract;
use App\Score\ScoreContract;
use App\Order\OrderContract;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    private static $userClass,$productClass,$likeClass,$commentClass;
    public function __construct(UserContract $userContract,ProductContract $productContract,
        LikeContract $likeContract,CommentContract $commentContract)
    {
        self::$userClass=$userContract;
        self::$productClass=$productContract;
        self::$likeClass=$likeContract;
        self::$commentClass=$commentContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken)[0];
        $allComments=count(self::$commentClass->GetUserAllComments($userInfo->id));
        $allLikes=count(self::$likeClass->GetUserAllLikes($userInfo->id));
        return [
            "status" => 200 , "infos" => [
                "allComments" => $allComments ,
                "allLikes" => $allLikes
            ]
        ];
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
        //
    }
}
