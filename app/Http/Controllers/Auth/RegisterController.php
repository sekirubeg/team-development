<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        // カスタム処理：画像あり／なし対応
        if ($request->hasFile('image_at')) {
            $imagePath = $request->file('image_at')->store('images', 'public');
        } else {
            $imagePath = 'img/default.png';
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image_at' => $imagePath,
        ]);

        Auth::login($user);

        return redirect($this->redirectPath());
    }

  

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image_at' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $imagePath = null;

        if (array_key_exists('image_at', $data) && $data['image_at']) {
            $imagePath = $data['image_at']->store('images', 'public');
        } else {
            $data['image_at'] = 'img/default.png'; // public/img 配下の画像
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image_at' => $imagePath,
        ]);

    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|confirmed|min:8',
    //         'image_at' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user = $this->create($request->all());

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'image_at' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // data配列を明示的に取得
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        // 画像の処理
        if ($request->hasFile('image_at')) {
            $data['image_at'] = $request->file('image_at')->store('images', 'public');
        } else {
            $data['image_at'] = 'img/default.png'; // public/img 配下の画像
        }

        // create() にパスを渡す
        $user = $this->create($data);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

}
