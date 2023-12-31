<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use  App\ContactUs\ContactContract;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\Panel\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    private static $contactClass,$userClass;
    public function __construct(ContactContract $contactContract){
        self::$contactClass=$contactContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts=self::$contactClass->GetAll();
        $contactsList=[];
        foreach ($contacts as $key => $contact) {
            $contactsList[]=new ContactUs($contact);
        }
        return ["status" => 200 , "contactsList" => $contactsList];
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
    public function store(ContactUsRequest $request)
    {
        self::$contactClass->Create($request);
        return ["status" => 200 , "message" => "نظرتان با موفقیت ثبت شد"];
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
