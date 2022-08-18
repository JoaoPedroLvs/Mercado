<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductsSale;
use App\Models\Promotion;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index(){
        $sales = Sale::orderBy('id', 'asc')->get();

        $data = [
            'sales' =>$sales
        ];

        return view('sale.show', $data);
    }

    public function create(){

        return $this->form(new Sale());

    }

    public function form(Sale $sale){

        $products = Product::orderBy('id','asc')->get();
        $customers = Customer::get();
        $employees = Employee::get();

        $data = [
            'customers' => $customers,
            'employees' => $employees,
            'sale' => $sale,
            'products' => $products
        ];

        return view('sale.form', $data);
    }

    public function insert(Request $request){

        $sale = new Sale();

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/sale')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());

        }
        else{

            $this->save($sale,$request);

            return redirect('/sales')->with('msg', 'Venda criada com sucesso');

        }
    }

    public function delete($id){

        $sale = Sale::find($id);

        $qty = Sale::searchQty($sale->id)->get();

        foreach($qty as $productQty){
            $product = Product::find($productQty->product_id);

            $product->increment('current_qty', $productQty->qty_sales);
        }

        $sale->delete();

        return redirect('/sales')->with('msg', 'Venda deletada com sucesso');
    }

    public function show($id){

        $sales = Sale::search($id)->get();

        $data = [
            'sales' => $sales
        ];

        return view('sale.show_products', $data);
    }

    private function validator(Request $request){

        $rules = [
            'customer_id' => 'required',
            'employee_id' => 'required',
        ];

        $msg = [
            'customer_id.' => 'necessário um cliente para registrar a compra',
            'employee_id.' => 'necessário um funcionário para registrar a compra',
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }
    private function save(Sale $sale, Request $request){

        DB::beginTransaction();
        try{

            $sale->customer_id = $request->customer_id;
            $sale->employee_id = $request->employee_id;

            $products = $request->product_id;

            $sale->save();

            foreach($products as $k => $product){

                $product = Product::find($product);

                $price = Promotion::searchPrice($product)->first();

                if($request->qty_sales[$k]){

                    $qty_sale = (int)$request->qty_sales[$k];


                    if(isset($price->is_active)){
                        $total_price = $qty_sale * $price->promotion;
                    }
                    else {
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

            DB::commit();

        } catch(Exception $e){

            dd($e);

            DB::rollBack();

        }

    }

}
