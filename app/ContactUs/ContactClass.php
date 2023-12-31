<?php
    namespace App\ContactUs;
    use App\Models\ContactUs;
    use Illuminate\Http\Request;

    class ContactClass implements ContactContract{
        public function GetRows(){
            return ContactUs::orderBy("id","DESC")->paginate(10);
        }
        public function GetAll(){
            return ContactUs::orderBy("id","DESC")->get();
        }
        public function Create(Request $request){
            $contact=new ContactUs();
            $contact->email=$request->email;
            $contact->message=$request->message;
            $contact->save();
        }
        // public function DataFormat($contactInfo){
        //     // $userInfo=$contactInfo->User;
        //     return [
        //         "id" => $contactInfo->id ,
        //         "message" => $contactInfo->message ,
        //         "email" => $contactInfo->email ,
        //         "updatedAt" => $contactInfo->updated_at
        //     ];
        // }
    }
?>
