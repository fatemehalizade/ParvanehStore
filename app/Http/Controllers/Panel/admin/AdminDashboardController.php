<?php

namespace App\Http\Controllers\Panel\admin;

use App\Http\Controllers\Controller;
use App\User\UserContract;
use App\Product\ProductContract;
use App\Like\LikeContract;
use App\Comment\CommentContract;
use App\Score\ScoreContract;
use App\Order\OrderContract;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    private static $userClass,$productClass,$likeClass,$commentClass,$scoreClass,$orderClass;
    public function __construct(UserContract $userContract,ProductContract $productContract,LikeContract $likeContract,
    CommentContract $commentContract,ScoreContract $scoreContract,OrderContract $orderContract)
    {
        self::$userClass=$userContract;
        self::$productClass=$productContract;
        self::$likeClass=$likeContract;
        self::$commentClass=$commentContract;
        self::$scoreClass=$scoreContract;
        self::$orderClass=$orderContract;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCustomers=count(self::$userClass->getAll())-1;
        $products=self::$productClass->GetAllIds();
        $allProducts=count($products);
        $likesInfo=self::$likeClass->GetAll();
        $allLikes=0;
        foreach ($likesInfo as $key => $likeInfo) {
            $allLikes += $likeInfo->count;
        }
        $allComments=count(self::$commentClass->GetAllComments());
        $latestProductsList=[];
        foreach ($products as $key => $product) {
            if($key < 6){
                $productInfo=self::$productClass->GetData($product->id);
                $latestProductsList[]=self::$productClass->DataFormat($productInfo["product"],$productInfo["productInfo"]);
            }
        }
        $comments=self::$commentClass->GetAllComments();
        $latestCommentsList=[];
        foreach ($comments as $key => $comment) {
            if($key < 6){
                $latestCommentsList[]=self::$commentClass->DataFormat($comment);
            }
        }
        $allOrders=0;
        if(count(self::$orderClass->GetAlls()) != 0){
            $allOrders=count(self::$orderClass->GetAlls());
        }
        $completedOrders=0;
        $paidOrders=0;
        $paidOrdersPrice=0;
        $orders=self::$orderClass->GetRows();
        // dd($orders);
        foreach ($orders as $key => $order) {
            if($order->status == 1){
                $completedOrders += 1;
            }
            else{
                $paidOrders += 1;
                $paidOrdersPrice += $order->price;
            }
        }
        $likes=self::$likeClass->SortMoreLikes();
        $moreLikeProductsList=[];
        foreach ($likes as $key => $like) {
            $productInfo=self::$productClass->GetData($like->product_id);
            $productAllInfo=self::$productClass->DataFormat($productInfo["product"],$productInfo["productInfo"]);
            $productAllInfo["likeCount"]=$like->count;
            $moreLikeProductsList=$productAllInfo;
        }
        $moreScoreProductsList=[];
        $scores=[];
        foreach ($products as $key => $product) {
            $scores[$product->id]=self::$scoreClass->GetScore($product->id);
        }
        ksort($scores);
        foreach ($scores as $key => $score) {
            $productInfo=self::$productClass->GetData($key);
            $productAllInfo=self::$productClass->DataFormat($productInfo["product"],$productInfo["productInfo"]);
            $productAllInfo["score"]=$score;
            $moreScoreProductsList[]=$productAllInfo;
        }
        return [
            "status" => 200 , "infos" => [
                "allCustomers" => $allCustomers ,
                "allProducts" => $allProducts ,
                "allLikes" => $allLikes ,
                "allComments" => $allComments ,
                "allOrders" => $allOrders ,
                "completedOrders" => $completedOrders ,
                "paidOrders" => $paidOrders ,
                "paidOrdersPrice" => $paidOrdersPrice ,
                "latestProducts" => $latestProductsList ,
                "latestComments" => $latestCommentsList ,
                "moreScoreProducts" => $moreScoreProductsList,
                "moreLikeProducts" => $moreLikeProductsList
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
