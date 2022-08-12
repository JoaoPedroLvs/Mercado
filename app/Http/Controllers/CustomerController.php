<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @return void
     */
    public function insert(Request $request) {
        $this->save(new Customer(), $request);

        return redirect('/customers')->with('msg', 'Criado com sucesso');
    }

    /**
     * Acha a cliente e chama a função de salvar
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request) {
        $customer = Customer::find($request->id);

        $this->save($customer, $request);

        return redirect('/customers')->with('msg', 'Editado com sucesso');
    }

    public function delete(Request $request){
        $customer=Customer::find($request->id);

        $customer->delete();

        return redirect('/customers')->with('msg', 'Excluido com sucesso');
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
