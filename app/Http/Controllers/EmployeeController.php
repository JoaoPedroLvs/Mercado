<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Employee Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 22/08/2022
 * @version 1.0.0
 */
class EmployeeController extends Controller
{

    /**
     * Exiber funcionários cadastrados
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index() {

        $employees = Employee::orderBy('id','asc')->get();

        $data = [
            'employees' => $employees
        ];

        return view('pages.employee.index', $data);

    }

    /**
     * Exibir dados de um funcionário
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $employee = Employee::find($id);

        $data = [
            'employee' => $employee
        ];

        return view('pages.employee.details', $data);
    }

    /**
     * Carrega formulário para cirar um novo funcionário
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $employee = new Employee();

        return $this->form($employee);
    }

    /**
     * Carrega o formulário para editar funcionário
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $employee = Employee::find($id);

        return $this->form($employee);
    }

    /**
     * Inserir novo funcionário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de um funcionário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover funcionário
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $employee = Employee::find($id);

            if (!$employee) {
                throw new \Exception('Funcionário não encontrado!');
            }

            $employee->delete();

            DB::commit();

            Session::flash('success', 'Cliente removido com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o funcionário: '.$e->getMessage());

        }

        return redirect('employees');
    }

    /**
     * Carregar formulário para criar/editar um funcionário
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Employee $employee) {

        $data = [
            'employee' => $employee,
        ];

        return view('pages.employee.form', $data);
    }

    /**
     * Inserir ou atualizar funcionário no banco de dados
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

                $employee = $isEdit ? Employee::find($request->id) : new Employee();

                $this->save($employee, $request);

                DB::commit();

                Session::flash('success', 'O funcionário foi '. ($isEdit ? 'alterado' : 'criado'). ' com sucesso');

                return redirect('employees');

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
            'work_code' => ['required', 'string']
        ];

        $validator = Validator::make($data,$rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:employees,id'], function() use ($method){
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salvar alterações do funcionário
     *
     * @param Employee $employee
     * @param Request $request
     * @return void
     */
    private function save(Employee $employee, Request $request) {

        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->cpf = $request->cpf;
        $employee->rg = $request->rg;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->work_code = $request->work_code;

        $employee->save();

    }
}
