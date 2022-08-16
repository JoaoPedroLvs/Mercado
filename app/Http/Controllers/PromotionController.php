<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index(){

        $promotions = Promotion::orderBy('id','asc')->get();

        // dd($promotions[0]->started_at->format('Y-m-d'));

        $data = [

            'promotions' => $promotions

        ];

        return view('promotion.show', $data);

    }

    public function create(){

        return $this->form(new Promotion());

    }

    public function edit($id){

        $promotion = Promotion::find($id);

        return $this->form($promotion);

    }

    public function form(Promotion $promotion){

        $products = Product::get();

        $isEdit = $promotion->id ? true : false;

        $data = [
            'products' => $products,
            'promotion' => $promotion,
            'isEdit' => $isEdit

        ];

        return view('promotion.form', $data);

    }

    public function insert(Request $request) {

        $promotion = new Promotion();

        $this->save($promotion, $request);

        return redirect('/promotions')->with('msg', 'Promoção criado com sucesso');

    }

    public function update(Request $request){

        $promotion = Promotion::find($request->id);

        $this->save($promotion, $request);

        return redirect('/promotions')->with('msg', 'Promoção editada com sucesso');

    }

    public function delete($id){

        $promotion = Promotion::find($id);

        $promotion->delete();

        return redirect('/promotions')->with('msg', 'Promoção apagada com sucesso');

    }

    private function save(Promotion $promotion, Request $request){

        try{

            DB::beginTransaction();

            $promotion->product_id = $request->product_id;
            $promotion->price = $request->price;
            $promotion->started_at = $request->started_at;
            $promotion->is_active = $request->is_active;
            $promotion->ended_at = $request->ended_at;

            $promotion->save();

            DB::commit();

        }catch(Exception $e){

            dd($e);

            DB::rollBack();

        }
    }
}
