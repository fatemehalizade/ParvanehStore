<?php

namespace App\Http\Middleware;

use App\User\UserContract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPanelMiddleWare
{
    private static $userClass;
    public function __construct(UserContract $userContract)
    {
        self::$userClass=$userContract;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(count($request->all()) != 0){
            if(isset($request->APItoken)){
                $userInfo=self::$userClass->GetDataByAPItoken($request->APItoken);
                if(count($userInfo) == 0){
                    return response()->json(["status" => 404 , "message" => "کاربری یافت نشد!"]);
                }
                else if($userInfo[0]->Role[0]["role"] != "customer"){
                    return response()->json(["status" => 404 , "message" => "کاربر صفحه پنل ادمین را درخواست کرده است"]);
                }
            }
            else{
                return response()->json(["status" => 404 , "message" => "کاربری یافت نشد!"]);
            }
        }
        else{
            return response()->json(["status" => 404 , "message" => "کاربری یافت نشد!"]);
        }
        return $next($request);
    }
}
