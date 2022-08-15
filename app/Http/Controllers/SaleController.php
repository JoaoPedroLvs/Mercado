<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductsSale;
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

        // dd($request->all());

        $sale = new Sale();

        $this->save($sale,$request);

        return redirect('/sales')->with('msg', 'Venda criada com sucesso');
    }

    public function delete($id){

        $sale = Sale::find($id);

        $sale->delete();

        return redirect('/sales')->with('msg', 'Venda deletada com sucesso');
    }

    public function show($id){

        $saleId = Sale::find($id);

        $sales = ProductsSale::search($id)->where('ps.sale_id', $saleId->id)->get();

        $data = [
            'sales' => $sales
        ];

        return view('sale.show_products', $data);
    }

    private function save(Sale $sale, Request $request){

        try{
            DB::beginTransaction();

            $sale->customer_id = $request->customer_id;
            $sale->employee_id = $request->employee_id;
            $sale->save();

            $products = $request->product_id;


            foreach($products as $k => $product_id){

                $productSale = new ProductsSale();
                $productSale->sale_id = $sale->id;


                $product = Product::find($product_id);


                $productSale->product_id = $request->product_id[$k];
                $productSale->qty_sales = $request->qty_sales[$k];
                $productSale->total_price = $product->price * $productSale->qty_sales;

                $product->decrement('current_qty', $productSale->qty_sales);

                // dd($productSale->total_price);

                $sale->increment('total',$productSale->total_price);

                $productSale->save();
            }


            DB::commit();

        }catch(Exception $e){

            dd($e);

            DB::rollBack();

        }

    }

}
