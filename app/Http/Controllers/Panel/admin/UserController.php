<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Panel\User;
use App\User\UserContract;
use Illuminate\Http\Request;

class UserController extends Controller
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
    public function index()
    {
        $users=self::$userClass->getAll();
        // self::$userClass->getRows();
        $usersList=[];
        foreach ($users as $key => $user) {
            if($user->Role[0]->role != "admin"){
                $usersList[]=new User($user);
            }
        }
        return ["status" => 200 , "usersList" => $usersList];
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
    public function store(UserRequest $request)
    {
        self::$userClass->Create($request);
        return ["status" => 200 ,"message" => "اطلاعات کاربر با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo=self::$userClass->GetData($id);
        return ["status" => 200 , "userInfo" => new User($userInfo)];
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
        self::$userClass->Delete($id);
        return ["status" => 200 ,"message" => "اطلاعات کاربر با موفقیت حذف شد"];
    }
}
