<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

        $employees = Employee::orderBy('id','asc')->paginate(10);

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

            $user = $employee->user;

            $employee->delete();

            $user->delete();

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

        // dd($request->email);

        $validator = $this->getInsertUpdateValidator($request);

        $user = Auth::user();

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $isEdit = $request->method() == 'PUT';

                $employee = $isEdit ? Employee::where('id',$request->id)->first() : new Employee();

                $user = $isEdit ? User::find($employee->user->id) : new User();

                $this->save($employee, $request, $user);

                DB::commit();

                Session::flash('success', 'O funcionário foi '. ($isEdit ? 'alterado' : 'criado'). ' com sucesso');

                if ($user->role == 0) {

                    return redirect('/');

                } else {

                    return redirect('employees');
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
            'name' => ['required_if:_method,post','max:250'],
            'email' => ['required_if:_method,post', 'email'],
            'rg' => ['required', 'string', 'max:14'],
            'cpf' => ['required_if:_method,post', 'string', 'max:14'],
            'address' => ['string', 'max:250'],
            'phone' => ['required', 'string'],
            'work_code' => ['required', 'string'],
            'password' => ['required_if:_method,post','confirmed']
        ];

        $employee = Employee::where('id',$request->id)->first();

        $validator = Validator::make($data,$rules);

        $user =  Auth::user();

        $validator->after(function ($validator) use ($request, $employee, $user) {

            if ($employee) {

                if ($employee->id != $user->employee->id) {

                    $validator = $validator->errors()->add('name','Não possui autorização para editar esse usuario');
                    return false;

                }

            }
            // dd($validator);
        });

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
    private function save(Employee $employee, Request $request, User $user) {


        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {

            $user->password = Hash::make($request->password);

        }
        $user->role = 0;

        $user->save();


        $employee->address = $request->address;
        $employee->cpf = $request->cpf;
        $employee->rg = $request->rg;
        $employee->phone = $request->phone;
        $employee->work_code = $request->work_code;
        $employee->is_new = false;
        $employee->user_id = $user->id;
        $employee->save();

    }

}
