<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    public function index(){

        $promotions = Promotion::orderBy('id','asc')->get();

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

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/create/promotion')->with('msg', 'Não foi possivel criar: '.$validator->errors()->first());

        }
        else{

            $this->save($promotion, $request);

            return redirect('/promotions')->with('msg', 'Promoção criado com sucesso');

        }


    }

    public function update(Request $request){

        $promotion = Promotion::find($request->id);

        $validator = $this->validator($request);

        if($validator->fails()){

            return redirect('/edit/promotion/'.$promotion->id)->with('msg', 'Não foi possivel editar: '.$validator->errors()->first());

        }
        else{

            $this->save($promotion, $request);
            return redirect('/promotions')->with('msg', 'Promoção editada com sucesso');

        }

    }

    public function delete($id){

        $promotion = Promotion::find($id);

        $promotion->delete();

        return redirect('/promotions')->with('msg', 'Promoção apagada com sucesso');

    }

    private function validator(Request $request){

        $rules = [

            'price'      => 'required|min:0.01',
            'started_at' => 'required|date:Y-m-d',
            'ended_at'   => 'required|date:Y-m-d'

        ];

        $msg = [

            'price.required' => 'preço necessário',
            'price.min' => 'digite pelo menos um preço de R$ 0,01',
            'started_at.required' => 'data de início necessário',
            'started_at.date' => 'data inválida',
            'ended_at.required' => 'data final inválida',
            'ended_at.date' => 'data inválida'

        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        return $validator;
    }

    private function save(Promotion $promotion, Request $request){

        try{

            DB::beginTransaction();

            $promotion->product_id = $request->product_id;
            $promotion->price = $request->price;
            $promotion->started_at = $request->started_at;
            $promotion->is_active = $request->is_active ?? false;
            $promotion->ended_at = $request->ended_at;

            $promotion->save();

            DB::commit();

        }catch(Exception $e){

            DB::rollBack();

        }
    }
}
