<?php
    namespace App\Payment;
    use App\Models\Payment;
    use Illuminate\Http\Request;

    class PaymentClass implements PaymentContract{
        public function Create(Request $request){
            $payment=new Payment();
            $payment->card_number=rand(1000000000000000,9999999999999999);
            $payment->transaction_number=rand(10000000,99999999);
            $payment->factor_id=$request->factorId;
            $payment->status=2;
            $payment->save();
            return $payment;
        }
        public function PaymentFormat($paymentInfo){
            $factorInfo=$paymentInfo->Factor;
            if($paymentInfo->status == 2){
                $status="پرداخت شده";
            }
            else if($paymentInfo->status == 1){
                $status="لغو شده";
            }
            else{
                $status="آماده پرداخت";
            }
            $cardNumber=trim($paymentInfo->card_number);
            $start=substr($cardNumber,0,4);
            $finish=substr($cardNumber,12,16);
            $hiddenCardNumber=$start."****".$finish;
            return [
                "id" => $paymentInfo->id ,
                "factorCode" => $factorInfo->factor_code ,
                "cardNumber" => $hiddenCardNumber ,
                "transactionNumber" => $paymentInfo->transaction_number ,
                "status" => $status ,
                "createdAt" => convertDateToFarsi($paymentInfo->created_at)
            ];
        }
    }
?>
