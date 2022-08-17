<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index(){
        $inventories = Inventory::orderBy('id','asc')->get();

        $data = [
            'inventories' => $inventories
        ];

        return view('inventory.show', $data);
    }

    public function create(){
        return $this->form(new Inventory());
    }

    public function edit($id){
        $inventory = Inventory::find($id);

        return $this->form($inventory);
    }

    public function form(Inventory $inventory){

        $isEdit = $inventory->id ? true : false;

        $products = Product::get();

        $data = [
            'isEdit' => $isEdit,
            'inventory' => $inventory,
            'products' => $products
        ];

        return view('inventory.form', $data);

    }

    public function insert(Request $request){
        $inventory = new Inventory();

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/inventory')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());

        }
        else{

            $this->save($inventory, $request);
            return redirect('/inventories')->with('msg', 'Estoque criado com sucesso');

        }


    }

    public function update(Request $request){
        $inventory = Inventory::find($request->id);

        $validator = $this->validator($request);

    }

    public function delete($id){
        $inventory = Inventory::find($id);

        $product = Product::find($inventory->product_id);

        $product->decrement('current_qty', $inventory->qty);

        $inventory->delete();

        return redirect('/inventories')->with('msg', 'Estoque excluido com sucesso');
    }

    private function validator(Request $request){

        $rules = [
            'qty' => 'required|min:1',
            'created_at' => 'required|date:Y-m-d'
        ];

        $msg = [
            'qty.required' => 'necessário uma quantidade',
            'qty.min' => 'necessário pelo menos 1 produto',
            'created_at.required' => 'necessário uma data',
        ];

        $validator = Validator::make($request->all(), $rules, $msg);
        return $validator;
    }

    private function save(Inventory $inventory, Request $request){

        try{

            DB::beginTransaction();


            $product = Product::find($request->product_id);

            $inventory->qty = $request->qty;

            $inventory->created_at = $request->created_at;

            $inventory->product_id = $request->product_id;

            $product->increment('current_qty', $request->qty);

            $inventory->save();

            DB::commit();

        }catch(Exception $e){

            dd($e);
            DB::rollBack();

        }

    }
}
