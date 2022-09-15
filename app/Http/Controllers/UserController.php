<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * User Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 31/08/2022
 * @version 1.0.0
 */
class UserController extends Controller
{
    /**
     * Redireciona a página com a listagem de todos os usuários
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';
        $search = $request->search;
        $qtyPaginate = $request->qtyPaginate ?? 10;

        $users = User::search($column, $order,$search)->paginate($qtyPaginate);

        $data = [
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'order' => $order,
            'users' => $users
        ];

        return view('pages.user.index', $data);
    }

    /**
     * Redireciona a página com os detalhes de determinado usuário
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $user = User::find($id);

        $data = [
            'user' => $user
        ];

        return view('pages.user.details', $data);

    }

    /**
     * Redireciona para a página de criação de usuário
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $user = new User();

        return $this->form($user);

    }

    /**
     * Redireciona para a página de edição de usuário
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $user = User::find($id);

        return $this->form($user);

    }

    /**
     * Insere um novo usuário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persiste as atualizações do usuário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Deleta o usuário
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $user = User::find($id);

            if (!$user) {

                throw new \Exception('Usuário não encontrado!');

            }

            $user->delete();

            DB::commit();

            Session::flash('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o usuário: '.$e->getMessage());
        }

        return redirect('users');

    }

    /**
     * Carregar formulário para criar/editar usuário
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(User $user) {

        $people = Person::get();
        $managers = Manager::get();
        $employees = Employee::get();
        $customers = Customer::get();

        $data = [
            'managers' => $managers,
            'employees' => $employees,
            'customers' => $customers,
            'user' => $user,
            'people' => $people
        ];

        return view('pages.user.form',$data);

    }

    /**
     * Salva alterações de usuário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOrUpdate(Request $request) {

        $validator = $this->getInsertUpdateValidator($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        }

        try {

            DB::beginTransaction();

            $isEdit = $request->method() == 'PUT';

            $user = $isEdit ? User::find($request->id) : new User();

            $this->save($user, $request);

            DB::commit();

            Session::flash('success', 'O usuário foi '.($isEdit ? 'alterado' : 'criado').' com sucesso!');

            return redirect('users');

        } catch (\Exception $e) {

            DB::rollBack();

            $error = $e->getMessage();

            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * Valida os dados do $request
     *
     * @param Request $request
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function getInsertUpdateValidator(Request $request) {

        $data = $request->all();

        $method = $request->method();

        if (isset($request->checkboxManager)) {

            $rules = [
                'manager_id' => ['required', 'exists:managers,id'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'confirmed']
            ];

        } else if (isset($request->chackboxEmployee)) {

            $rules = [
                'employee_id' => ['required', 'exists:employees,id'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'confirmed']
            ];

        } else if (isset($request->checkboxCustomer)) {
            $rules = [
                'customer_id' => ['required', 'exists:customers,id'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'confirmed']
            ];
        } else {

            $rules = [
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'confirmed']
            ];

        }

        $validator = Validator::make($data,$rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:users,id'], function() use ($method){
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salva alterações no banco de dados
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function save(User $user, Request $request) {

        if ($request->checkboxManager) {

            $user->manager_id = $request->manager_id;

        }

        if ($request->checkboxEmployee) {

            $user->employee_id = $request->employee_id;

        }

        if ($request->checkboxCustomer) {

            $user->customer_id = $request->customer_id;

        }

        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

    }

}
