<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    public function redireactGoogle(){
        return $this->redirect('google');
    }

    public function callbackGoogle(){
        return $this->callbackSocial('google');
    }

    public function redireactFacebook(){
        return $this->redirect('facebook');
    }

    public function callbackFacebook(){
        return $this->callbackSocial('facebook');
    }

    public function redirect($social){
        return Socialite::driver($social)->redirect();
    }
    public function callbackSocial($social){
        try {
            $socialUser = Socialite::driver($social)->user();
            $user = resolve(UserRepository::class)->getUserByEmail($socialUser->getEmail());
            if (!$user) {
                $data = [
                    'name'              => $socialUser->getName(),
                    'email'             => $socialUser->getEmail(),
                    'email_verified_at' => now(),
                    'password'          => Hash::make('social'),
                ];
                $newUser = resolve(UserRepository::class)->create($data);
                \Auth::login($newUser);

                return redirect('/');
            } else {
                \Auth::login($user);

                return redirect('/');
            }
        }catch (\Throwable $th){
            dd('loi',$th);
        }
    }
}
