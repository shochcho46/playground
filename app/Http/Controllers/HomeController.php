<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Gender;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    public function dashboard(Request $request)
    {

        return view('user.dashboard');
    }

    public function login()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.login',compact('datas','genders'));

    }




    public function registration()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.register',compact('datas','genders'));

    }


    public function validateLogin(Request $request)
    {
        $countryIso = Country::where('id',18)->first();

        $validated = $request->validate([
            // 'email_or_phone' => ['bail','required','regex:/^[0-9+]+$/',(new Phone)->country([$countryIso->iso])],
            'email_or_phone' => ['bail','required'],

            'password' => 'required',
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );


        $password = $request->input('password');

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email_or_phone)
            // ->orWhere('phone', $phoneNumber)
            ->first();
        }
        else
        {
            $phoneNumber = validationMobileNumber($request->email_or_phone,$countryIso->iso);
            $user = User::where('email', $request->email_or_phone)
                    ->orWhere('phone', $phoneNumber)
                    ->first();
        }



        if ($user) {
            if (Hash::check($password, $user->password))
            {

                if (($user->status == 0)) {

                    return back()->with('fail', 'This account is in black listed');
                } else {

                    if ($request->has('remember')) {
                        Auth::guard('web')->login($user, true);
                    } else {
                        Auth::guard('web')->login($user);
                    }
                    return redirect()->route('user.dashboard');
                }

            }

            else
            {
                return back()->with('fail', 'Wrong Credential');
            }
        }
        else
        {
            return back()->with('fail', 'Wrong Credential');
        }
    }





    public function storRegistration(Request $request)
    {
        $code = rand(100000,999999);
        $countryIso = Country::where('id',$request->country_id)->first();
        // dd($countryIso->iso);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            // 'education_type_id' => 'required',
            'phone' => ['required','unique:users','regex:/^[0-9+]+$/',(new Phone)->country([$countryIso->iso]??['BD']),],
            // 'upazila_id' => 'required',
            // 'district_id' => 'required',
            // 'division_id' => 'required',
            'gender_id' => 'required',
            'country_id' => 'required',
            ],
            [
                'phone.regex' => 'The phone number must contain only English digits (0-9).',
                'phone.required' => 'The phone number is required',
            ]
        );

        $phoneNumber = validationMobileNumber($request->phone,$countryIso->iso);

            $user = DB::transaction(function () use($request,$code,$phoneNumber) {
                $userCreate = array(
                    "name" => $request->name,
                    "email" => $request->email ?? null,
                    "password" => Hash::make($request->password),
                    "phone" => $phoneNumber,
                    "otp" => $code,
                    "status" => 1,

                );

                $newuser = User::create($userCreate);

                $userdetail = array(
                    "user_id" => $newuser->id,
                    "division_id" => $request->division_id ?? null,
                    "district_id" => $request->district_id ?? null ,
                    "upazila_id" => $request->upazila_id ?? null ,
                    "union_id" => $request->union_id ?? null ,
                    "education_type_id" => $request->education_type_id ?? null ,
                    "profession_id" => $request->profession_id ?? null ,
                    "gender_id" => $request->gender_id ?? null ,
                    "country_id" => $request->country_id ?? null ,
                    "religion_id" => $request->religion_id ?? null ,
                );
                $userDetail = UserDetail::create($userdetail);

                // $role_name = Role::where('id',$request->role_type)->first();

                // $newuser->assignRole($role_name->name);
                return $newuser;
            });

            if ($user->status == 0) {

                return back()->with('fail', 'This account is in black listed');
            } else {

                return back()->with('success', 'This account is created');
            }
    }


    public function googleOauthLoad()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleOauthCallBack()
    {
        $user = Socialite::driver('google')->user();
        dd( $user);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('login');
    }
}
