<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Alluser;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\NilUuid;

class imgcontroller extends Controller
{
    public function productAPIPost(Request $request){
        $var = new Product();
        
        $var->P_name = $request->P_name;
        $file=$request->file('imgfile');
        $fileextension=$request->file('imgfile')->getClientOriginalName();
        $filename=time()."-".$fileextension;
        $file->move('img/product',$filename);
        $var->P_img=$filename;
        $var->save();

        return "ok";
    }

    public function productAPIList(){
        return Product::all();
    }

    public function registationapi(Request $request){
        $validate=$request->validate([

            'username'=>'required',
            'Email'=>'required',
            'password'=>'required',
           
            
            
       ],
       [
           'username.required'=>'Please put your First name',
           'Email.required'=>'Please put your First name',
           'password.required'=>'Please put your First name',
           
           
           

           
           
       ]
       
       );
        $randomnumber=random_int(100000,999999);
        $var = new Alluser();
        
        $var->username = $request->username;
        $var->Email = $request->Email;
        $var->password = $request->password;
        $var->validationcode = $randomnumber;
        $var->validationconfirm="Waiting";
        $var->save();
        if($var!=null)
        {
            controlleemail::signupemail($var->username,$var->Email,$var->validationcode);
            return "successfully";
        }
        else
        {
            return "wrong";
        }
        
    }

    public function validationreg(Request $request){
        $validationcode=$request->validationcode;
        $user = Alluser::select('*')->where('validationcode',$validationcode)->where('validationconfirm',"Waiting")->first();
       if ($user!=null) {
        $user->validationconfirm="Done";
        $user->save();
         return "successfully";
       }
       else
       {
        return "";
       }
            
    }
}
