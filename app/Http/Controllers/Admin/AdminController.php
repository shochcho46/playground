<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class AdminController extends Controller
{

    public function adminLogin()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.admin.login',compact('datas','genders'));

    }

    public function adminValidateLogin(Request $request)
    {

        $countryIso = Country::where('id',18)->first();

        $validated = $request->validate([
            'email_or_phone' => ['bail','required'],
            'password' => 'required',
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {

            $credential = array("email" => $request->email_or_phone, "password" => $request->password);
        }
        else
        {
            $phoneNumber = validationMobileNumber($request->email_or_phone,$countryIso->iso);
            $credential = array("phone" => $phoneNumber, "password" => $request->password);
        }

        if (Auth::guard('admin')->attempt($credential)) {

            $user = Auth::guard('admin')->user();

            if (($user->status == 0)) {

                return back()->with('fail', 'This account is in black listed');
            } else {

                return redirect()->route('admin.dashboard');
            }

        }


        else
        {
            return back()->with('fail', 'Wrong Credential');
        }
    }
    public function dashboard()

    {

        return view('admin.dashboard');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('adminLogin');
    }
}
