<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function showProduct (int $id) {

        $product = Product::find($id);

        if (!Storage::disk('local')->exists('/private/product'.DIRECTORY_SEPARATOR.$product->image)) {
            abort(404);
        }

        return response()->file(storage_path('app/private/product'.DIRECTORY_SEPARATOR.($product->image)));
    }
}
