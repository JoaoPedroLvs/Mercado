<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Category Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 23/08/2022
 * @version 1.0.0
 */
class CategoryController extends Controller
{
    /**
     * Exibir categorias criadas
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';
        $search = $request->search;
        $qtyPaginate = $request->qtyPaginate ?? 10;

        $categories = Category::search($column,$order,$search)->paginate($qtyPaginate);

        $data = [
            'qtyPaginate' => $qtyPaginate,
            'search' => $search,
            'order' => $order,
            'categories' => $categories
        ];

        return view('pages.category.index', $data);

    }

    /**
     * Exibir dados de uma categoria
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $category = Category::find($id);

        $products = $category->products;

        $data = [
            'category' => $category,
            'products' => $products
        ];

        return view('pages.category.details', $data);
    }

    /**
     * Carregar formulário para criar uma nova categoria
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $category = new Category();

        return $this->form($category);
    }

    /**
     * Carregar formulário para editar uma categoria
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $category = Category::find($id);

        return $this->form($category);

    }

    /**
     * Inserir uma nova categoria no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de uma categoria no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover categoria
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $category = Category::find($id);

            if (!$category) {
                throw new \Exception('Categoria não encontrada');
            }

            // dd($category->products);
            $this->preDelete($category);


            $category->delete();

            DB::commit();

            Session::flash('success', 'Categoria deletada com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover a categoria: '. $e->getMessage());

        }

        return redirect('categories');
    }

    /**
     * Carregar formulário para criar/editar uma categoria
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form (Category $category) {

        $data = [
            'category' => $category
        ];

        return view('pages.category.form', $data);
    }

    /**
     * Inserir formulário para criar/editar uma categoria
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

                $category = $isEdit ? Category::find($request->id) : new Category();

                $this->save($category, $request);

                DB::commit();

                Session::flash('success', 'A categoria foi '. ($isEdit ? 'alterada' : 'criada') .' com sucesso!');

                return redirect('categories');

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
    private function getInsertUpdateValidator(Request $request) {

        $data = $request->all();

        $method = $request->method() == 'PUT';

        $rules = [
            'name' => ['required','max:250']
        ];

        $validator = Validator::make($data, $rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:categories,id'], function() use ($method){
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Deleta os produtos relacionados a categoria
     *
     * @param integer $id
     * @return void
     */
    private function preDelete(Category $category) {

        $products = $category->products;

        foreach ($products as $product) {

            $promotions = $product->promotions;

            $promotions->each->delete();

            if ($product->sales = []) {
                throw new \Exception('tem um produto que está presente em pelo menos uma venda');
            }

        }

        $products->each->delete();

    }

    /**
     * Salva as alterações no banco de dados
     *
     * @param Category $category
     * @param Request $request
     * @return void
     */
    private function save(Category $category, Request $request) {

        $category->name =$request->name;

        $category->save();

    }
}
