<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Inventory Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 23/08/2022
 * @version 1.0.0
 */
class InventoryController extends Controller
{

    /**
     * Exibir os estoques criados
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';
        $search = $request->search;
        $qtyPaginate = $request->qtyPaginate ?? 10;

        $inventories = Inventory::search($column,$order,$search)->paginate($qtyPaginate);

        $data = [
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'order' => $order,
            'inventories' => $inventories
        ];

        return view('pages.inventory.index', $data);
    }

    /**
     * Carregar formulário para criar um novo estoque
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $inventory = new Inventory();

        return $this->form($inventory);
    }

    /**
     * Inserir nova estoque no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOnly($request);

    }

    /**
     * Deleta o estoque
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $inventory = Inventory::find($id);

            if (!$inventory) {
                throw new \Exception('Estoque não encontrado');
            }

            $this->preDelete($inventory->product->id, $inventory->qty);

            $inventory->delete();

            DB::commit();

            Session::flash('success', 'Estoque removido com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o estoque: '. $e->getMessage());
        }

        return redirect('inventories');
    }

    /**
     * Carregar formulário para criar um estoque
     *
     * @param Inventory $inventory
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Inventory $inventory) {

        $products = Product::get();

        $data = [
            'inventory' => $inventory,
            'products' => $products
        ];

        return view('pages.inventory.form', $data);

    }

    /**
     * Insere um estoque no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOnly(Request $request) {

        $validator = $this->getInsertValidator($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $inventory = new Inventory();

                $this->save($inventory, $request);

                DB::commit();

                Session::flash('success', 'O estoque foi criado com sucesso!');

                return redirect('inventories');

            } catch (\Exception $e) {

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
    private function getInsertValidator(Request $request) {

        $data = $request->all();

        $rules = [
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'min:1'],
            'created_at' => ['required', 'date:Y-m-d']
        ];

        $validator = Validator::make($data,$rules);

        return $validator;
    }

    /**
     * Decrementa a quantidade total do produto
     *
     * @param int $id
     * @param int $qty
     * @return void
     */
    private function preDelete(int $id, int $qty) {

        $product = Product::find($id);
        $product->decrement('current_qty', $qty);

    }

    /**
     * Salva o estoque no banco de dados
     *
     * @param Inventory $inventory
     * @param Request $request
     * @return void
     */
    private function save(Inventory $inventory, Request $request) {

        $product = Product::find($request->product_id);

        $inventory->qty = $request->qty;

        $inventory->created_at = $request->created_at;

        $inventory->product_id = $request->product_id;

        $product->increment('current_qty', $request->qty);

        $inventory->save();

    }
}
