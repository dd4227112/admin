<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;


class QrCode extends Controller
{
   public function generate_qr_code(){
            $user_email = request()->segment(3);
            
            $qr_code = new \App\Http\Controllers\BarcodeQR();
            $targetPath = "public/";
            $user_url = 'https://admin.shulesoft.com/user-details/' . md5($user_email);
            $qr_code->url($user_url);
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $qr_code_name = 'images/qrcode/'.md5($user_email). '.png';
            $qr_code_push = $targetPath.$qr_code_name;
            $generate_qr_code = $qr_code->draw(150, $qr_code_push);
            $update_user = User::where('email',$user_email)->update(['qr_code'=>$qr_code_name]);
    
            if ($generate_qr_code){
                return redirect()->back()->with('success', 'QR code has been Generated');
            }
            else{
                return redirect()->back()->with('error', 'Sorry failed Generate QR Code may be due to network problem,please try again');
            }
        }

}
