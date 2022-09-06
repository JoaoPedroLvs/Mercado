<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Customer Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 22/08/2022
 * @version 1.0.0
 */
class CustomerController extends Controller
{

    /**
     * Exibir clientes cadastrados
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index() {

        $customers = Customer::orderBy('id','asc')->paginate(10);

        $data = [
            'customers' => $customers
        ];

        return view('pages.customer.index', $data);
    }

    /**
     * Exibir dados de um cliente
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $customer = Customer::find($id);

        $data = [
            'customer' => $customer
        ];

        return view('pages.customer.details', $data);
    }

    /**
     * Carregar formulário para criar um novo cliente
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $customer = new Customer();

        return $this->form($customer);

    }

    /**
     * Carrega formulário para editar um cliente
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $customer = Customer::find($id);

        return $this->form($customer);

    }

    /**
     * Inserir novo cliente no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de um cliente no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover cliente
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $customer = Customer::find($id);

            if (!$customer) {
                throw new \Exception('Cliente não encontrado!');
            }

            $customer->delete();

            DB::commit();

            Session::flash('success', 'Cliente removido com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o cliente: '.$e->getMessage());
        }

        return redirect('customers');
    }

    /**
     * Carregar formulário para criar/editar um cliente
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Customer $customer) {

        $data = [
            'customer' => $customer
        ];

        return view('pages.customer.form',$data);
    }

    /**
     *  Inserir ou atualizar cliente no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOrUpdate(Request $request) {

        $validator = $this->getInsertUpdateValidator($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $isEdit = $request->method() == 'PUT';

                $customer = $isEdit ? Customer::find($request->id) : new Customer();

                $user = $isEdit ? User::find($customer->user->id) : new User();

                $this->save($customer, $request, $user);

                DB::commit();

                Session::flash('success', 'O cliente foi '. ($isEdit ? 'alterado' : 'criado'). ' com sucesso!');

                if ($user->role == 2) {

                    return redirect('/customer/'.$customer->id.'/show');

                } else {

                    return redirect('customers');

                }


            } catch (\Exception $e) {

                DB::rollBack();

                $error = $e->getMessage();

                return back()->withInput()->withErrors($error);
            }
        }
    }

    /**
     * Valida os dados do $request
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function getInsertUpdateValidator(Request $request) {

        $data = $request->all();

        $method = $request->method();

        $rules = [
            'name' => ['required', 'max:250'],
            'email' => ['required', 'email'],
            'rg' => ['required', 'string', 'max:14'],
            'cpf' => ['required', 'string', 'max:14'],
            'address' => ['required', 'string', 'max:250'],
            'phone' => ['required', 'string'],
            'password' => ['required_if:_method,post','confirmed']
        ];

        $validator = Validator::make($data, $rules);

        $customer = Customer::where('id',$request->id)->first();

        $user = Auth::user();

        $validator->after(function ($validator) use ($request, $customer, $user) {

            if ($customer) {

                if ($customer->id != $user->customer->id) {

                    $validator = $validator->errors()->add('name', 'Não possui autorização para editar esse cliente');
                    return false;
                }
            }
        });

        $validator->sometimes('id', ['required', 'integer', 'exists:customers,id'], function() use ($method){
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salvar alterações do cliente
     *
     * @param Request $request
     * @param Customer $customer
     * @return void
     */
    private function save(Customer $customer, Request $request, User $user) {

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {

            $user->password = Hash::make($request->password);
        }

        if ($request->file('image')) {

            $file = $request->image;
            $filename = date('YmdHi').$user->name;
            $file->move(public_path('/assets/img'), $filename);
            $user->image = $filename;

        }

        $user->save();

        $customer->rg = $request->rg;
        $customer->cpf = $request->cpf;
        $customer->address = $request->address;
        $customer->phone = $request->phone;

        $customer->is_new = false;

        $customer->save();

    }

}
