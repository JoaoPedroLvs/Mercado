<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Person;
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

        $managers = Manager::search($column,$order,$search)->paginate($qtyPaginate);

        $data = [
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'order' => $order,
            'managers' => $managers
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

        $manager = Manager::searchManager($id)->first();

        $data = [
            'manager' => $manager
        ];

        return view('pages.admin.details', $data);

    }

    /**
     * Carregar o formulário para criar novo administrador
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $manager = new Manager();

        return $this->form($manager);
    }

    /**
     * Carregar o formulário para editar um administrador
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $manager = Manager::find($id);

        return $this->form($manager);
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

            $manager = Manager::find($id);

            if (!$manager) {

                throw new \Exception('Administrador não encontrado!');
            }

            $manager->delete();

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
    public function form(Manager $manager) {

        $people = Person::get();

        $data = [
            'manager' => $manager,
            'people' => $people
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

                $manager = $isEdit ? Manager::find($request->id) : new Manager();

                $person = $manager->person ?? new Person();

                $this->save($manager, $request, $person);

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

        if (!isset($request->checkbox)) {

            $rules = [
                'person_id' => ['required', 'exists:people,id']
            ];

        } else {

            $rules = ['name' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'string', 'max:16'],
            'rg' => ['required', 'string', 'max:14'],
            'phone' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:350']
            ];
        }

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
    private function save(Manager $manager, Request $request, Person $person) {

        if (isset($request->checkbox)) {

            $person->name = $request->name;
            $person->cpf = $request->cpf;
            $person->rg = $request->rg;
            $person->phone = $request->phone;
            $person->gender = $request->gender;
            $person->address = $request->address;

            $person->save();

        }

        if (!$manager->person_id) {

            if ($request->person_id) {

                $manager->person_id = $request->person_id;

            } else {

                $manager->person_id = $person->id;
            }

            $manager->save();
        }

    }
}
