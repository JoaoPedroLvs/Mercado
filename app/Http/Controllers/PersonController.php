<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
/**
 * Person Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 13/09/2022
 * @version 1.0.0
 */
class PersonController extends Controller
{
    /**
     * Lista todas as pessoas criadas
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';
        $qtyPaginate = $qtyPaginate ?? 10;
        $search = $request->search ?? null;

        $people = Person::search($column,$order,$search)->paginate($qtyPaginate);

        $data = [
            'search' => $search,
            'qtyPaginate' => $qtyPaginate,
            'people' => $people,
            'order' => $order
        ];

        return view('pages.people.index', $data);

    }

    /**
     * Mostra detalhes de uma determinada pessoa
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $person = Person::find($id);

        $data = [
            'person' => $person
        ];

        return view('pages.people.details', $data);
    }

    /**
     * Redireciona para a página de criação de uma pessoa
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {
        $person = new Person();

        return $this->form($person);

    }

    /**
     * Redireciona para a página de edição
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $person = Person::find($id);

        return $this->form($person);

    }

    /**
     * Salva uma nova pessoa no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persiste autalizações de uma pessoa no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remove uma pessoa do banco de dados
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $person = Person::find($id);

            if (!$person) {
                throw new \Exception('Pessoa não encontrada!');
            }

            $this->preDelete($person);

            $person->delete();

            DB::commit();

            Session::flash('success', 'Pessoa removida com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possivel remover a pessoa: '.$e->getMessage());
        }

        return redirect('people');
    }

    /**
     * Redireciona para o formulário de criação / edição de uma pessoa
     *
     * @param Person $person
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Person $person) {

        $data = [
            'person' => $person
        ];

        return view('pages.people.form', $data);

    }

    /**
     * Inseria ou atualiza uma pessoa no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOrUpdate(Request $request) {


        $validator = $this->validateInsertUpdate($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $isEdit = $request->method() == 'PUT';

                $person = $isEdit ? Person::find($request->id) : new Person();

                $customer = $request->customer ? new Customer() : null;

                $employee = $request->employee ? new Employee() : null;

                $manager = $request->manager ? new Manager() : null;

                $this->save($request, $person, $customer, $employee, $manager);

                DB::commit();

                Session::flash('success', 'A pessoa foi '.($isEdit ? 'editado' : 'criado').' com sucesso!');

                if (Session::has('customer')) {
                    return redirect('customer/'.$person->customer->id.'/show');
                }

                if ($customer) {

                    return redirect('customers');

                } else if ($employee) {

                    return redirect('employees');

                } else if ($manager) {

                    return redirect('managers');

                } else {

                    return redirect('people');

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
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validateInsertUpdate(Request $request) {

        $data = $request->all();

        $method = $request->method();

        if ($request->employee) {

            $rules = [
                'work_code' => ['required', 'string'],
                'role_id' => ['required', 'exists:employee_roles,id'],
                'name' => ['required', 'string', 'max:150'],
                'cpf' => ['required', 'string', 'max:16'],
                'rg' => ['required', 'string', 'max:14'],
                'phone' => ['required', 'string', 'max:15'],
                'gender' => ['required', 'string', 'max:1'],
                'address' => ['required', 'string', 'max:350']
            ];
        }
        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'string', 'max:16'],
            'rg' => ['required', 'string', 'max:14'],
            'phone' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:350']
        ];

        $validator = Validator::make($data, $rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:people,id'], function() use ($method) {
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salva as alterações no banco de dados
     *
     * @param Request $request
     * @param Person $person
     * @return void
     */
    private function save (Request $request, Person $person, Customer $customer = null, Employee $employee = null, Manager $manager = null) {

        $person->name = $request->name;
        $person->cpf = $request->cpf;
        $person->rg = $request->rg;
        $person->phone = $request->phone;
        $person->gender = $request->gender;
        $person->address = $request->address;

        $person->save();

        if ($person->customer) {

            $customer = $person->customer;

            $customer->is_new = false;

            $customer->save();
        }

        if ($customer) {

            $customer->person_id = $person->id;
            $customer->is_new = false;

            $customer->save();

        } else if ($employee) {

            $employee->person_id = $person->id;
            $employee->work_code = $request->work_code;
            $employee->role_id = $request->role_id;

            $employee->save();

        } else if ($manager) {

            $manager->person_id = $person->id;

            $manager->save();

        }


    }

    /**
     * Deleta tudo relacionado com determinada pessoa
     *
     * @param Person $person
     * @return void
     */
    private function preDelete(Person $person) {

        // dd($person->employee);
        if (isset($person->manager)) {

            if (isset($person->manager->user)) {

                $user = $person->manager->user;
                $user->delete();

            }

            $manager = $person->manager();
            $manager->delete();

        }

        if (isset($person->employee)) {

            if (isset($person->employee->user)) {

                $user = $person->employee->user;

                $user->delete();

            }

            $employee = $person->employee();
            $employee->delete();
        }

        if (isset($person->customer)) {

            if (isset($person->customer->user)) {

                $user = $person->customer->user;

                $user->delete();

            }

            $customer = $person->customer();
            $customer->delete();
        }

    }

}
