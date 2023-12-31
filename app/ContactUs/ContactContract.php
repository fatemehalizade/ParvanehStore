<?php
    namespace App\ContactUs;
    use Illuminate\Http\Request;

    interface ContactContract{
        public function GetRows();
        public function GetAll();
        public function Create(Request $request);
        // public function DataFormat($contactInfo);
    }
?>
