<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return $this->save($employee, $request);

    }

    public function update(Request $request){
        $employee = Employee::find($request->id);

        return $this->save($employee, $request);

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

    private function save(Employee $employee, Request $request){

        DB::beginTransaction();

        try{
            if($employee->id == null){
                $isEdit = false;
            }
            else{
                $isEdit = true;
            }
            $employee->name = $request->name;
            $employee->address = $request->address;
            $employee->cpf = $request->cpf;
            $employee->rg = $request->rg;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->work_code = $request->work_code;

            $employee->save();

            DB::commit();

            if($isEdit){

                return redirect('/employees')->with('msg', 'Editado com sucesso');

            }
            else{

                return redirect('/employees')->with('msg', 'Criado com sucesso');

            }

        }catch(Exception $e){
            DB::rollBack();
        }
    }
}
