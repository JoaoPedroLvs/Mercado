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

        return $this->save($category, $request);

    }

    public function update(Request $request){
        $category = Category::find($request->id);

        return $this->save($category, $request);

    }

    public function delete($id){
        $category = Category::find($id);

        $category->delete();

        return redirect('/categories')->with('msg', 'Deletado com sucesso');
    }

    private function save(Category $category, Request $request){

        DB::beginTransaction();

        $rules = [
            'name' => 'required|max:250'
        ];

        $msg = [
            'name.required' => 'nome necessário',
            'name.max' => 'nome inválido'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        if($validator->fails()){
            if($category->id){

                return redirect('/edit/category/'.$category->id)->with('msg', 'Não foi possível editar: '.$validator->errors()->first());

            }
            else{

                return redirect('/create/categories')->with('msg', 'Não foi possível criar: '.$validator->errors()->first());

            }
        }

        try{
            $category->name =$request->name;

            $category->save();

            DB::commit();

            if($category->id){

                return redirect('/categories')->with('msg', 'Editado com sucesso');

            }
            else{

                return redirect('/categories')->with('msg', 'Criado com sucesso');

            }

        }catch(Exception $e){

            DB::rollBack();
        }

    }
}
