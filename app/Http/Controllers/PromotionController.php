<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Promotion Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 23/08/2022
 * @version 1.0.0
 */
class PromotionController extends Controller
{

    /**
     * Exibir  as promoções criadas
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index() {

        $promotions = Promotion::orderBy('id','asc')->paginate(10);

        $data = [

            'promotions' => $promotions

        ];

        return view('pages.promotion.index', $data);

    }

    /**
     * Carregar formulário para criar uma promoção
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $promotion = new Promotion();

        return $this->form($promotion);

    }

    /**
     * Carregar formulário para editar uma promoção
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id) {

        $promotion = Promotion::find($id);

        return $this->form($promotion);

    }

    /**
     * Inserir uma promoção no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Persistir atualizações de uma promoção no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        return $this->insertOrUpdate($request);

    }

    /**
     * Remover uma promoção
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $promotion = Promotion::find($id);

            if (!$promotion) {
                throw new \Exception('Promoção não encontrada');
            }

            $promotion->delete();

            DB::commit();

            Session::flash('success', 'Promoção removida com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover a promoção: '.$e->getMessage());
        }

        return redirect('promotions');
    }

    /**
     * Carregar formulário para criar/editar uma promoção
     *
     * @param Promotion $promotion
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Promotion $promotion) {

        $products = Product::get();

        $data = [
            'products' => $products,
            'promotion' => $promotion
        ];

        return view('pages.promotion.form', $data);

    }

    /**
     * Inserir ou atualizar promoções no banco de dados
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

                $promotion = $isEdit ? Promotion::find($request->id) : new Promotion();

                $this->save($promotion, $request);

                DB::commit();

                Session::flash('success', 'Promoção '. ($isEdit ? 'alterada' : 'criada') .' com sucesso!');

                return redirect('promotions');

            } catch (\Exception $e) {

                DB::rollBack();

                $error = $e->getMessage();

                return back()->withInput()->withErrors($error);

            }

        }
    }

    /**
     * Valida os dados do$request
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function getInsertUpdateValidator(Request $request) {

        $data = $request->all();

        $method = $request->method();

        $rules = [

            'product_id' => ['required', 'exists:products,id'],
            'price'      => ['required', 'min:0.01'],
            'started_at' => ['required', 'date:Y-m-d'],
            'ended_at'   => ['required', 'date:Y-m-d']

        ];


        $validator = Validator::make($data, $rules);

        $validator->sometimes('id', ['required', 'integer', 'exists:promotions,id'], function() use ($method) {
            return $method == 'PUT';
        });

        return $validator;
    }

    /**
     * Salva alterações no banco de dados
     *
     * @param Promotion $promotion
     * @param Request $request
     * @return void
     */
    private function save(Promotion $promotion, Request $request) {

        $promotion->product_id = $request->product_id;
        $promotion->price = floatval(str_replace(',','.',$request->price));
        $promotion->started_at = $request->started_at;
        $promotion->is_active = $request->is_active ?? false;
        $promotion->ended_at = $request->ended_at;

        $promotion->save();

    }
}
