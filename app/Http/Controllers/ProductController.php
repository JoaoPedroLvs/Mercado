<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $this->save($product, $request);

    }

    public function update(Request $request){
        $product = Product::find($request->id);

        $this->save($product, $request);

    }

    public function delete($id){
        $product = Product::find($id);

        $product->delete();

        return redirect('/products')->with('msg', 'Produto deletado com sucesso');
    }

    private function save(Product $product, Request $request){

        try{

            if($product->id == null){

                $isEdit = false;

            }
            else{

                $isEdit = true;

            }

            DB::beginTransaction();

            $product->name = $request->name;
            $product->price = $request->price;

            $product->category_id = $request->category_id;

            $product->save();

            DB::commit();

            if($isEdit){

                return redirect('/products')->with('msg', 'Produto editado com sucesso');

            }
            else{

                return redirect('/products')->with('msg', 'Produto criado com sucesso');

            }

        }catch(Exception $e){

            DB::rollBack();

        }
    }
}
