<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('id', 'asc')->get();

        $data = [
            'products' => $products
        ];

        return view('product.show', $data);
    }

    public function create(){
        return $this->form(new Product());
    }

    public function edit($id){
        $product = Product::find($id);

        return $this->form($product);
    }

    public function form(Product $product){
        $isEdit = $product->id ? true : false;

        $categories = Category::get();

        $data = [
            'categories' => $categories,
            'product' => $product,
            'isEdit' => $isEdit
        ];

        return view('product.form', $data);
    }

    public function insert(Request $request){
        $product = new Product();

        $validator = $this->validator($request);

        if($validator->fails()){
            return redirect('/create/product')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());
        }
        else{

            $this->save($product, $request);

            return redirect('/products')->with('msg', 'Produto criado com sucesso');

        }


    }

    public function update(Request $request){
        $product = Product::find($request->id);

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/edit/product/'.$product->id)->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());
        }
        else{

            $this->save($product, $request);

            return redirect('/products')->with('msg', 'Produto editado com sucesso');

        }

    }

    public function delete($id){
        $product = Product::find($id);

        $product->delete();

        return redirect('/products')->with('msg', 'Produto deletado com sucesso');
    }

    private function validator(Request $request){

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|min:0.01',
        ];

        $msg = [
            'name.required' => 'nome é necessário',
            'name.max' => 'nome inválido',
            'price.required' => 'preço é necessário',
            'price.min' => 'insira um valor de pelo menos R$ 0,01'

        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }

    private function save(Product $product, Request $request){

        DB::beginTransaction();

        try{

            $product->name = $request->name;
            $product->price = $request->price;

            $product->category_id = $request->category_id;

            $product->save();

            DB::commit();

        }catch(Exception $e){

            DB::rollBack();

        }
    }
}
