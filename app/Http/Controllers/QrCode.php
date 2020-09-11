<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;


class QrCode extends Controller
{
   public function generate_qr_code(){
            $user_email = request()->segment(3);
            
            $qr_code = new BarcodeQR();
            $targetPath = "images/qrcode/";
            $user_url = 'https://www.admin.shulesoft.com/user-details/' . md5($user_email) ;
            $qr_code->url($user_url);
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $qr_code_name = $targetPath.md5($user_email). '.png';
            $qr_code->draw(150, $qr_code_name);
            $update_user = User::where('email',$user_email)->update(['qr_code'=>$qr_code_name]);
    
            if ($update_user){
                return redirect()->back()->with('success', 'QR code has been Generated');
            }
            else{
                return redirect()->back()->with('error', 'Sorry failed try again');
            }

           
 
}
}
