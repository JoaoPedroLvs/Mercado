<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Admin Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 31/08/2022
 * @version 1.0.0
 */
class AdminController extends Controller
{
    /**
     * Exibir adminstradores cadastrados
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';
        $search = $request->search;
        $qtyPaginate = $request->qtyPaginate ?? 10;

        $users = User::searchAdmin($column,$order,$search)->paginate($qtyPaginate);

        $data = [
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'order' => $order,
            'users' => $users
        ];

        return view('pages.admin.index', $data);
    }

    /**
     * Exibir detalhes de um administrador
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $user = User::find($id);

        $data = [
            'user' => $user
        ];

        return view('pages.admin.details', $data);

    }

    /**
     * Carregar o formulário para criar novo administrador
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $admin = new User();

        return $this->form($admin);
    }

    /**
     * Carregar o formulário para editar um administrador
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $admin = User::find($id);

        return $this->form($admin);
    }

    /**
     * Inserir novo administrador no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de um administrador no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover um administrador
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $user = User::find($id);

            if (!$user) {

                throw new \Exception('Administrador não encontrado!');
            }

            $user->delete();

            DB::commit();

            Session::flash('success', 'O administrador foi deletado com sucesso!');

            return redirect('admins');

        } catch (\Exception $e) {

            DB::rollBack();

            $error = $e->getMessage();

            return back()->withInput()->withErrors($error);

        }

    }

    /**
     * Carregar o formulário para criar/editar um administrador
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(User $user) {

        $data = [
            'user' => $user
        ];

        return view('pages.admin.form', $data);
    }

    /**
     * Inserir ou atualizar administrador no banco de dados
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

                $admin = $isEdit ? User::find($request->id) : new User();

                $this->save($admin, $request);

                DB::commit();

                Session::flash('success', 'O administrador foi '. ($isEdit ? 'alterado' : 'criado') .' com sucesso!');

                return redirect('admins');

            } catch(\Exception $e) {

                DB::rollBack();

                $error = $e->getMessage();

                return back()->withInput()->withErrors($error);

            }
        }
    }

    /**
     * Valida o $request
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function getInsertUpdateValidator(Request $request) {

        $data = $request->all();

        $method = $request->method();

        $rules = [
            'name' => ['required', 'max:100'],
            'email' => ['required_if:_method,post', 'email'],
            'password' => ['required_if:_method,post', 'confirmed', 'string']
        ];

        $validator = Validator::make($data,$rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:users,id'], function() use ($method) {
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salva as alterações no banco de dados
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function save(User $user, Request $request) {

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role = 1;
        $user->save();
    }
}
