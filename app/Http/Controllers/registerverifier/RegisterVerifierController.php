<?php

namespace App\Http\Controllers\registerverifier;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class RegisterVerifierController extends Controller
{
    use UtilityHelper;
    public function getVerifier($confirmationCode){
        $user = $this->getObjectFirstRecord('users',array('confirmation_code'=>$confirmationCode));
        if(empty($user)){
            return redirect('auth/login');
        }else{
            return view('verifier.input_password_for_verification',
                            compact('user'));
        }
        
    }

    public function postVerifier(Request $request){
        $this->validate($request, [
            'password' => 'required|min:8|same:confirmation_password',
        ]);
        $toUpdateItems = array('confirmation_code'=>null,
                                'password'=>bcrypt($request->input('password')));
        $this->updateRecord('users',array($request->input('userid')),$toUpdateItems);
        return redirect('auth/login');
    }
}
