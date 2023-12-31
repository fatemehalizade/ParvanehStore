<?php

namespace App\Http\Controllers\Panel\customer;

use App\Http\Controllers\Controller;
use App\User\UserContract;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Panel\User;
use Illuminate\Http\Request;

class ProfileCustomerController extends Controller
{
    private static $userClass;
    public function __construct(UserContract $userContract)
    {
        self::$userClass=$userContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customerInfo=self::$userClass->GetDataByAPItoken($request->APItoken)[0];
        return ["status" => 200 , "customerInfo" => new User($customerInfo)];
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
    public function update(UserRequest $request, $id)
    {
        self::$userClass->Update($request,$id);
        return ["status" => 200 ,"message" => "اطلاعات کاربر با موفقیت ویرایش شد"];
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
