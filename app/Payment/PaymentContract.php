<?php
    namespace App\Payment;
    use App\Models\Payment;
    use Illuminate\Http\Request;

    interface PaymentContract{
        public function Create(Request $request);
        public function PaymentFormat($paymentInfo);
    }
?>
