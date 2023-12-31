<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerRequest;
use App\Http\Resources\Panel\Producer;
use App\Producer\ProducerContract;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    private static $producerClass;
    public function __construct(ProducerContract $producerContract)
    {
        self::$producerClass=$producerContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producers=self::$producerClass->GetAll();
        // self::$producerClass->GetRows();
        $producersList=[];
        foreach ($producers as $key => $producer) {
            $producersList[]=new Producer($producer);
        }
        return ["status" => 200 , "producersList" => $producersList];
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
    public function store(ProducerRequest $request)
    {
        self::$producerClass->Create($request);
        return ["status" => 200 , "message" => "تولید کننده موادغذایی با موفقیت ثبت شد"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producerInfo=self::$producerClass->GetData($id);
        return ["status" => 200 , "producerInfo" => new Producer($producerInfo)];
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
    public function update(ProducerRequest $request, $id)
    {
        self::$producerClass->Update($request,$id);
        return ["status" => 200 , "message" => "تولید کننده موادغذایی با موفقیت ویرایش شد"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::$producerClass->Delete($id);
        return ["status" => 200 , "message" => "تولید کننده موادغذایی با موفقیت حذف شد"];
    }
}
