<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Product\ProductContract;
use PhpParser\JsonDecoder;

class ProductRequest extends FormRequest
{
    private static $productClass;
    public function __construct(ProductContract $productContract){
        self::$productClass=$productContract;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $ProductInfoId=0;
        if($this->product != null){
            $ProductInfoId=self::$productClass->GetData($this->product)["productInfo"]->id;
        }
        return [
            "image" => $this->product == null ? "required|mimes:png,jpg,jpeg|max:15360" : "nullable|image|mimes:png,jpg,jpeg|max:15360" ,
            "productName" => "required" ,
            "count" => "required" ,
            "price" => "required" ,
            "weight" => "required" ,
            "healthLicenceNumber" => "required|unique:product_infos,health_licence_number,".$ProductInfoId ?? 0 ,
            "categoryId" => "required" ,
            "brandId" => "required" ,
            "packageTypeId" => "required" ,
            "producerId" => "required" ,
            "tags" => "required" ,
            "description" => "required" ,
        ];
    }
}
