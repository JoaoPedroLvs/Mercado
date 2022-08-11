<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(){
        $inventories = Inventory::get();

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

        $this->save($inventory, $request);

        return redirect('/inventories')->with('msg', 'Estoque criado com sucesso');
    }

    public function update(Request $request){
        $inventory = Inventory::find($request->id);

        $this->save($inventory, $request);

        return redirect('/inventories')->with('msg', 'Estoque editado com sucesso');
    }

    public function delete($id){
        $inventory = Inventory::find($id);

        $product = Product::find($inventory->product_id);

        $product->decrement('current_qty', $inventory->qty);

        $inventory->delete();

        return redirect('/inventories')->with('msg', 'Estoque excluido com sucesso');
    }

    private function save(Inventory $inventory, Request $request){

        // dd($request->all());

        $product = Product::find($request->product_id);

        $inventory->qty = $request->qty;

        $inventory->created_at = $request->created_at;

        $inventory->product_id = $request->product_id;

        $product->increment('current_qty', $request->qty);

        $product->save();

        $inventory->save();
    }
}
