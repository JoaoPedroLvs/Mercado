<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

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
            'cpf' => ['required', 'string', 'max:14', 'unique:people'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return void
     */
    protected function create(array $data)
    {

        try {

            DB::beginTransaction();

            $request = (object) $data;

            $this->save($request);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $error = $e->getMessage();

            return back()->withInput()->withErrors($error);

        }

    }

    /**
     * Salva no banco de dados um novo cliente
     *
     * @param object $request
     * @return void
     */
    private function save(object $request) {

        $person = new Person();
        $person->name = $request->name;
        $person->cpf = $request->cpf;

        $person->save();

        $customer = new Customer();

        $customer->person_id = $person->id;
        $customer->save();

        $user = new User();

        $user->customer_id = $customer->id;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

    }
}
