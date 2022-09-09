<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Sale Controller
 *
 * @author João Pedro Alves <joaopedro@sysout.com.br>
 * @since 23/08/2022
 * @version 1.0.0
 */
class SaleController extends Controller
{
    /**
     * Exibir vendas criadas
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request) {

        $column = $request->column ?? 'id';
        $order = $request->order ?? 'asc';

        $sales = Sale::orderBy($column, $order)->paginate(10);

        $salesPrice = Sale::get();

        $total = 0;

        foreach ($salesPrice as $sale) {

            $total += $sale->total;

        }

        $data = [
            'order' => $order,
            'sales' => $sales,
            'total' => $total
        ];

        return view('pages.sale.index', $data);
    }

    /**
     * Exibir os produtos que foram vendido na determiada venda
     *
     * @param integer $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id) {

        $sales = Sale::search($id)->get();

        $data = [
            'sales' => $sales
        ];

        return view('pages.sale.details', $data);
    }

    /**
     * Carrega o formulário para criar uma venda
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $sale = new Sale();

        return $this->form($sale);

    }

    /**
     * Inserir nova venda no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        return $this->insertOnly($request);

    }

    /**
     * Deletar venda
     *
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) {

        try {

            DB::beginTransaction();

            $sale = Sale::find($id);

            if (!$sale) {
                throw new \Exception('Venda não encontrada');
            }

            $qty = Sale::searchQty($sale->id)->get();


            foreach ($qty as $productQty) {

                $product = Product::find($productQty->product_id);

                $product->increment('current_qty', $productQty->qty_sales);

            }

            $this->preDelete($sale);

            $sale->delete();

            DB::commit();

            Session::flash('success', 'Venda removida com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            Session::flash('error', 'Não foi possível remover a venda: '.$e->getMessage());
        }

        return redirect('sales');

    }

    /**
     * Carrega o formulário para criar uma venda
     *
     * @param Sale $sale
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function form(Sale $sale) {

        $products = Product::orderBy('id','asc')->get();
        $customers = Customer::get();
        $employees = Employee::get();

        $data = [
            'customers' => $customers,
            'employees' => $employees,
            'sale' => $sale,
            'products' => $products
        ];

        return view('pages.sale.form', $data);
    }

    /**
     * Inserir a venda no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    private function insertOnly(Request $request) {

        $validator = $this->insertValidator($request);

        if ($validator->fails()) {

            $error = $validator->errors()->first();

            return back()->withInput()->withErrors($error);

        } else {

            try {

                DB::beginTransaction();

                $sale = new Sale();

                $this->save($sale, $request);

                DB::commit();

                Session::flash('success', 'Venda criada com sucesso!');

                return redirect('sales');

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
    private function insertValidator(Request $request) {

        $data = $request->all();

        $rules = [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'qty_sales' => ['required'],
            'product_id' => ['required', 'exists:products,id']
        ];

        $validator = Validator::make($data, $rules);

        return $validator;
    }

    private function preDelete(Sale $sale) {

        $sale->products()->detach();

    }

    /**
     * Salva a venda no banco de dados
     *
     * @param Sale $sale
     * @param Request $request
     * @return void
     */
    private function save(Sale $sale, Request $request) {

        $sale->customer_id = $request->customer_id;

        if (!Auth::user()->role == 1) {

            $sale->employee_id = Auth::user()->employee->id;
        } else {
            $sale->employee_id = null;
        }


        $products = $request->product_id;

        $sale->save();

        foreach ($products as $k => $product) {

            $product = Product::find($product);

            $price = Promotion::searchPrice($product)->first();

            if ($request->qty_sales[$k]) {

                $qty_sale = (int)$request->qty_sales[$k];

                if (isset($price->is_active)) {

                    $total_price = $qty_sale * $price->promotion;
                    $total_no_promotion = $qty_sale * $price->product;

                    $sale->increment('total_no_promotion', $total_no_promotion);
                } else {

                    $total_price = $qty_sale * $price->product;

                }

                $attachArray = [
                    'qty_sales' => $qty_sale,
                    'total_price' => $total_price
                ];

                $sale->products()->attach($product->id, $attachArray);

                $product->decrement('current_qty', $qty_sale);

                $sale->increment('total',$total_price);


            }

        }

    }

}
