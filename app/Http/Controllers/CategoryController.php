<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('id','asc')->get();

        $data = [
            'categories' => $categories
        ];

        return view('category.show', $data);
    }

    public function show($id){

        $category = Category::find($id);

        $products = $category->products;

        $data = [
            'category' => $category,
            'products' => $products
        ];

        return view('category.show_products', $data);
    }

    public function create(){
        return $this->form(new Category());
    }

    public function edit($id){

        $category = Category::find($id);

        return $this->form($category);

    }

    public function form (Category $category){

        $isEdit = $category->id ? true : false;

        $data = [
            'category' => $category,
            'isEdit' => $isEdit
        ];

        return view('category.form', $data);
    }

    public function insert(Request $request){
        $category = new Category();

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/categories')->with('msg', 'Não foi possível criar: '.$validator->errors()->first());

        }
        else{

            $this->save($category,$request);

            return redirect('/categories')->with('msg', 'Criado com sucesso');

        }
    }

    public function update(Request $request){
        $category = Category::find($request->id);

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/edit/category/'.$category->id)->with('msg', 'Não foi possível editar: '.$validator->errors()->first());

        }
        else{

            $this->save($category, $request);

            return redirect('/categories')->with('msg', 'Editado com sucesso');

        }

    }

    public function delete($id){
        $category = Category::find($id);

        $category->delete();

        return redirect('/categories')->with('msg', 'Deletado com sucesso');
    }

    private function validator(Request $request){

        $rules = [
            'name' => 'required|max:250'
        ];

        $msg = [
            'name.required' => 'nome necessário',
            'name.max' => 'nome inválido'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }

    private function save(Category $category, Request $request){


        DB::beginTransaction();

        try{

            $category->name =$request->name;

            $category->save();

            DB::commit();

        }catch(Exception $e){

            DB::rollBack();
        }

    }
}
