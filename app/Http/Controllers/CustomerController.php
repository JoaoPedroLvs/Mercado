<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Mostra todos os clientes
     *
     * @return void
    */



    public function index()
    {

        $customers = Customer::orderBy('id','asc')->get();

        // dd($customers);

        $data = [
            'customers' => $customers
        ];

        return view('customer.show', $data);
    }

    public function show(Request $request){
        $customer = Customer::find($request->id);

        $data = [
            'customer' => $customer
        ];

        return view('customer.profile', $data);
    }

    /**
     * Criar novo cliente
     *
     * @return void
     */
    public function create() {
        return $this->form(new Customer());
    }

    /**
     * Atualizar um cliente
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id) {

        $customer = Customer::find($id);

        return $this->form($customer);
    }

    /**
     * Chamar a view do formulário
     *
     * @param Customer $customer
     * @return void
     */
    public function form(Customer $customer){

        $isEdit = $customer->id ? true : false;

        return view('customer.form', ['customer' => $customer, 'isEdit' => $isEdit]);
    }

    /**
     * Cria um novo cliente e chama a função de salvar
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/customer')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());

        }
        else{

            $this->save(new Customer(), $request);
            return redirect('/customers')->with('msg', 'Cliente criado com sucesso');

        }

    }

    /**
     * Acha a cliente e chama a função de salvar
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        $customer = Customer::find($request->id);

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/edit/customer/'.$customer->id)->with('msg', 'Não foi possivel editar: '.$validator->errors()->first());

        }
        else{

            $this->save($customer, $request);
            return redirect('/customers')->with('msg', 'Editado com sucesso');
        }


    }

    public function delete(Request $request){
        $customer=Customer::find($request->id);

        $customer->delete();

        return redirect('/customers')->with('msg', 'Excluido com sucesso');
    }

    /**
     * Valida os dados do $request
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validator(Request $request){

        $rules = [
            'name' => 'required|max:250',
            'email' => 'required|email',
            'rg' => 'required|string|max:14',
            'cpf' => 'required|string|max:14',
            'address' => 'required|string|max:250'
        ];

        $msg = [
            'name.required' => 'nome necessário',
            'name.max' => 'nome inválido',
            'email.required' => 'necessário um email para o cadastro',
            'email.email' => 'email inválido',
            'rg.required' => 'necessário um RG para o cadastro',
            'rg.max' => 'RG inválido',
            'cpf.required' => 'necessário um CPF para o cadastro',
            'cpf.max' => 'CPF inválido',
            'address.required' => 'necessário um endereço para o cadastro',
            'address.max' => 'endereço inválido'

        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }

    /**
     * Salvar alterações do cliente
     *
     * @param Request $request
     * @param $customer
     * @return void
     */
    private function save(Customer $customer, Request $request)
    {
        DB::beginTransaction();

        try{

            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->rg = $request->rg;
            $customer->cpf = $request->cpf;
            $customer->address = $request->address;

            $customer->save();

            DB::commit();

        }catch(Exception $e){

            DB::rollBack();

        }
    }
}
