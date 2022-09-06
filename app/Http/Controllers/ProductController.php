<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Product Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 23/08/2022
 * @version 1.0.0
 */
class ProductController extends Controller
{

    /**
     * Exibir produtos cadastrados
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $products = Product::search()->orderBy('id', 'asc')->paginate(10);

        $data = [
            'request' => $request,
            'products' => $products
        ];

        return view('pages.product.index', $data);

    }

    /**
     * Carregar o formulário para criar novo produto
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $product = new Product();

        return $this->form($product);
    }

    /**
     * Carregar o formulário para editar um produto
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $product = Product::find($id);

        return $this->form($product);

    }

    /**
     * Inserir novo produto no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de um produto no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover um produto
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $product = Product::find($id);

            if (!$product) {
                throw new \Exception('Produto não encontrado!');
            }

            $this->preDelete($product);

            $product->delete();

            DB::commit();

            Session::flash('success', 'Produto excluído com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover o produto: '. $e->getMessage());

        }

        return redirect('products');
    }

    /**
     * Carregar o formulário para criar/editar um produto
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Product $product) {

        $categories = Category::get();

        $data = [
            'categories' => $categories,
            'product' => $product
        ];

        return view('pages.product.form', $data);
    }

    /**
     * Inserir ou atualizar produto no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOrUpdate(Request $request) {

        $validator = $this->getInsertUpdateValidator($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $isEdit = $request->method() == 'PUT';

                $product = $isEdit ? Product::find($request->id) : new Product();

                $this->save($product, $request);

                DB::commit();

                Session::flash('success', 'O produto foi '. ($isEdit ? 'alterado' : 'criado') .' com sucesso!');

                return redirect('products');

            } catch (\Exception $e) {

                DB::rollBack();

                $error = $e->getMessage();

                return back()->withInput()->withErrors($error);

            }
        }
    }

    /**
     * Valida os dados do $request
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function getInsertUpdateValidator(Request $request){

        $data = $request->all();

        $method = $request->method();

        $rules = [
            'name' => ['required', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required']
        ];

        $validator = Validator::make($data,$rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:products,id'], function() use ($method){
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Deletar todas as promoções relacionadas aquele produto
     *
     * @param Product $product
     * @return void
     */
    private function preDelete(Product $product) {

        // dd(count($product->sales));

        if (count($product->sales) > 0) {
            throw new \Exception('ele está presente em pelo menos uma venda');
        }

        Inventory::where('product_id', $product->id)->delete();
        Promotion::where('product_id', $product->id)->delete();

    }

    /**
     * Salvar alterações do produto
     *
     * @param Product $product
     * @param Request $request
     * @return void
     */
    private function save(Product $product, Request $request) {

        $product->name = $request->name;

        //Vetores para substituir espaçe em branco e virgula no banco de dados
        $string = [
            ' ',
            ','
        ];

        $stringR = [
            '',
            '.'
        ];

        $product->price = floatval(str_replace($string,$stringR,$request->price));
        $product->category_id = $request->category_id;

        $product->save();
    }
}
