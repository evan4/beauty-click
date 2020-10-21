<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Socialite\Facades\Socialite;

class CreateNewUser implements CreatesNewUsers
{
    private $redirectToDashboard = '/dashboard';
    private $providerPassword = 'secret12';

    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }

     /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        $userProvider = Socialite::driver('facebook')->user();
        dd($userProvider);
        $user = User::where('email', $userProvider->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $userProvider->getName(),
                'email' => $userProvider->getEmail(),
                'provider_id' => $userProvider->getId(),
                'password' => $this->providerPassword,
                'email_verified_at' => now()
            ]);
        }

       $this->userProviderAuth();
    }


    /**
     * Redirect the user to the vkontakte authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToVkontakte()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    /**
     * Obtain the user information from vkontakte.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleVkontakteCallback()
    {
        $userProvider = Socialite::driver('vkontakte')->user();
        dd($userProvider);
        $user = User::where('email', $userProvider->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $userProvider->name(),
                'email' => $userProvider->getEmail(),
                'provider_id' => $userProvider->id(),
                'password' => $this->providerPassword,
                'email_verified_at' => now()
            ]);
        }

       $this->userProviderAuth();
    }
    
    
    /**
     * Redirect the user to the odnoklassniki authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToOdnoklassniki()
    {
        return Socialite::driver('odnoklassniki')->redirect();
    }

    /**
     * Obtain the user information from odnoklassniki.
     *
     * @return \Illuminate\Http\Response
     */
    public function handlenOklassnikiCallback()
    {
        $userProvider = Socialite::driver('odnoklassniki')->user();
        dd($userProvider);
        $user = User::where('email', $userProvider->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $userProvider->name(),
                'email' => $userProvider->getEmail(),
                'provider_id' => $userProvider->id(),
                'password' => $this->providerPassword,
                'email_verified_at' => now()
            ]);
        }

       $this->userProviderAuth();
    }


    /**
     * Redirect the user to the yandex authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToYandex()
    {
        return Socialite::driver('yandex')->redirect();
    }

    /**
     * Obtain the user information from yandex.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleYandexCallback()
    {
        $userProvider = Socialite::driver('yandex')->user();
        dd($userProvider);
        $user = User::where('email', $userProvider->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $userProvider->name(),
                'email' => $userProvider->getEmail(),
                'provider_id' => $userProvider->id(),
                'password' => $this->providerPassword,
                'email_verified_at' => now()
            ]);
        }

       $this->userProviderAuth();
    }


    /**
     * Redirect the user to the google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $userProvider = Socialite::driver('google')->user();
        dd($userProvider);
        $user = User::where('email', $userProvider->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $userProvider->name(),
                'email' => $userProvider->getEmail(),
                'provider_id' => $userProvider->id(),
                'password' => $this->providerPassword,
                'email_verified_at' => now()
            ]);
        }

       $this->userProviderAuth();
    }

    private function userProviderAuth($user)
    {
        $role = Role::where('id', 1);
        $user->assignRole($role);
        
        Auth::login($user, true);
        return redirect($this->redirectToDashboard);
    }
}
