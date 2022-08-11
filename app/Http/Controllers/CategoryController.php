<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::get();

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

        $this->save($category, $request);

        return redirect('/categories')->with('msg', 'Criado com sucesso');
    }

    public function update(Request $request){
        $category = Category::find($request->id);

        $this->save($category, $request);

        return redirect('/categories')->with('msg', 'Editado com sucesso');
    }

    public function delete($id){
        $category = Category::find($id);

        $category->delete();

        return redirect('/categories')->with('msg', 'Deletado com sucesso');
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
