<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Employee Role Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 12/09/2022
 * @version 1.0.0
 */
class EmployeeRoleController extends Controller
{
        /**
     * Mostra todos os cargos criados
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index (Request $request) {

        $qtyPaginate = $request->qtyPaginate ?? 10;
        $order = $request->order ?? 'asc';
        $column = $request->column ?? 'id';
        $search = $request->search;

        $roles = EmployeeRole::search($column, $order, $search)->paginate($qtyPaginate);

        $data = [
            'order' => $order,
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'roles' => $roles
        ];

        return view('pages.employees-roles.index', $data);

    }

    /**
     * Mostra todos os funcionários que possuem determinado cargo
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show (Request $request) {

        $qtyPaginate = $request->qtyPaginate ?? 10;
        $order = $request->order ?? 'asc';
        $column = $request->column ?? 'id';
        $search = $request->search;

        $employees = Employee::search($column, $order, $search)->paginate($qtyPaginate);

        $data = [

            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'employee' => $employees

        ];

        return view('pages.employees-roles.details', $data);
    }

    /**
     * Redireciona para a página de criação de cargo
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create () {

        $role = new EmployeeRole();

        return $this->form($role);

    }

    /**
     * Redireciona para a página de edição de cargo
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit (int $id) {

        $role = EmployeeRole::find($id);

        return $this->form($role);

    }

    /**
     * Remove um cargo
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete (int $id) {

        try {

            DB::beginTransaction();

            $role = EmployeeRole::find($id);

            if (!$role) {
                throw new \Exception('cargo não encontrado!');
            }

            if (count($role->employee) > 0) {

                throw new \Exception('funcionários atrelados a ele!');

            }

            $role->delete();

            DB::commit();

            Session::flash('success', 'Cargo removido com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o cargo: '.$e->getMessage());

        }

        return redirect('employees/roles');
    }

    /**
     * Inserir novo cargo no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert (Request $request) {

        return $this->insertOrUpdate($request);
    }

    /**
     * Persistir atualizações de um cargo no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update (Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Redireciona para a página de criação / edição de cargo
     *
     * @param EmployeeRole $role
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form (EmployeeRole $role) {

        $data = [
            'role' => $role
        ];

        return view('pages.employees-roles.form', $data);
    }

    /**
     * Inserir ou atualizar um cargo no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOrUpdate (Request $request) {

        $validator = $this->validateInsertUpdate($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);
        } else {

            try {

                DB::beginTransaction();

                $isEdit = $request->method() == "PUT";

                $role = $isEdit ? EmployeeRole::find($request->id) : new EmployeeRole();

                $this->save($request, $role);

                DB::commit();

                Session::flash('success', 'O cargo foi '. ($isEdit ? 'editado' : 'criado') .' com sucesso!');

                return redirect('employees/roles');

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
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validateInsertUpdate (Request $request) {

        $data = $request->all();

        $method = $request->method();

        $rules = [
            'name' => ['required', 'max:250']
        ];

        $validator = Validator::make($data, $rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:employee_roles,id'], function() use ($method) {
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salva as alterações no banco de dados
     *
     * @param Request $request
     * @param EmployeeRole $role
     * @return void
     */
    private function save (Request $request, EmployeeRole $role) {

        $role->name = $request->name;
        $role->save();

    }
}
