<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::orderBy('id','asc')->get();

        $data = [
            'employees' => $employees
        ];

        return view('employee.show', $data);
    }

    public function create(){

        return $this->form(new Employee());
    }

    public function edit($id){
        $employee = Employee::find($id);

        return $this->form($employee);
    }

    public function form(Employee $employee){

        $isEdit = $employee->id ? true : false;

        $data = [
            'employee' => $employee,
            'isEdit' => $isEdit
        ];

        return view('employee.form', $data);
    }

    public function insert(Request $request){
        $employee = new Employee();

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/employee')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());
        }
        else{

            $this->save($employee, $request);

            return redirect('/employees')->with('msg', 'Criado com sucesso');

        }


    }

    public function update(Request $request){
        $employee = Employee::find($request->id);

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/edit/employee/'.$employee->id)->with('msg', 'Não foi possivel editar: '.$validator->errors()->first());
        }
        else{

            $this->save($employee, $request);

            return redirect('/employees')->with('msg', 'Editado com sucesso');

        }

    }

    public function delete($id){
        $employee = Employee::find($id);

        $employee->delete();

        return redirect('/employees')->with('msg', 'Excluido com sucesso');
    }

    public function show($id){
        $employee = Employee::find($id);

        $data = [
            'employee' => $employee
        ];

        return view('employee.profile', $data);
    }

    private function validator(Request $request){

        $rules = [
            'name' => 'required|max:100',
            'address' => 'required|max:250',
            'cpf' => 'required|string|max:14',
            'rg' => 'required|string|max:14',
            'email' => 'required|email',
            'phone' => 'required|string',
            'work_code' => 'required|string'
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
            'address.max' => 'endereço inválido',
            'work_code.required' => '',
            'work_code.' => ''
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }

    private function save(Employee $employee, Request $request){

        DB::beginTransaction();

        try{

            $employee->name = $request->name;
            $employee->address = $request->address;
            $employee->cpf = $request->cpf;
            $employee->rg = $request->rg;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->work_code = $request->work_code;

            $employee->save();

            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
        }
    }
}
