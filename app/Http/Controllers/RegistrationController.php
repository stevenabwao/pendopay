<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationForm;
use App\Http\Requests\RegistrationRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    
    /*create a new user*/
    public function addUser(RegistrationForm $form){

        //$form->persist();
        /*$user = User::create(
            $this->only(['first_name', 'last_name', 'email', 'password', 'gender'])
        );*/

        $user = User::create([
                    'first_name' => request()->first_name,
                    'last_name' => request()->last_name,
                    'email' => request()->email,
                    'password' => bcrypt(request()->password),
                    'gender' => request()->gender
                  ]);

        //$user->save();

        $resultData = User::where('id', $user->id)->first();

        //event(new ChatMessage($chat));

        return response(['data' => $resultData], 201); 
        
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
    
}
