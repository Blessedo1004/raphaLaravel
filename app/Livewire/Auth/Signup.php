<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\PreregisterEmail;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Sign Up')]
class Signup extends Component
{
    public $first_name;
    public $last_name;
    public $user_name;
    public $phone_number;
    public $email;
    public $password;
    public $password_confirmation;

    // Custom messages only for password fields
    protected $messages = [
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
        'password.regex' => 'Password must be a minimum of 8 characters, with at least one uppercase and lowercase letter, number and special character',
        'password.confirmed' => 'Passwords do not match',
    ];

    public function updated($property)
    {
        $this->validateOnly($property, $this->rules(), $this->messages);
            if ($property === 'password_confirmation') {
        $this->validateOnly('password', $this->rules(), $this->messages);
    }
    }

protected function rules(): array
{
    return [
        'first_name' => [
            'required',
            'string',
            'min:3',
            'max:20',
            'regex:/^[^<>]*$/',
        ],

        'last_name' => [
            'required',
            'string',
            'min:3',
            'max:20',
            'regex:/^[^<>]*$/',
        ],

        'user_name' => [
            'required',
            'string',
            'min:6',
            'max:20',
            'unique:users,user_name',
            'regex:/^[^<>]*$/',
        ],

        'phone_number' => [
            'required',
            'string',
            'size:11',
            'regex:/^[^<>]*$/',
        ],

        'email' => [
            'required',
            'email',
            'unique:users,email',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
            'confirmed',
        ],
    ];
}

    public function signup()
    {
        $userData = $this->validate($this->rules(), $this->messages);

        $existingCode = Cache::get('preregister_email_token' . $userData['email']);
        if ($existingCode) {
            Cache::forget('preregister_user' . $existingCode);
            Cache::forget('preregister_email_token' . $userData['email']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('preregister_user' . $code, $userData, 60 * 20);
        Cache::put('preregister_email_token' . $userData['email'], $code, 60 * 20);

        Mail::to($userData['email'])->send(new PreregisterEmail($code));

        session()->flash('show_preregister_notice', true);

        return redirect()->route('preregister.notice')->with('email', $userData['email']);
    }

    public function render()
    {
        if(Auth::check()){
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin-dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('livewire.auth.signup');
    }
}