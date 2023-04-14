<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::with('category')->get();

        if ($products->isEmpty()) {
            return $this->respondWithError('No product found', 404);
        }

        return $this->respondWithData($products);
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = collect();
            foreach ($validator->errors()->getMessages() as $key => $value) {
                foreach ($value as $error) {
                    $errors->push($error);
                }
            }

            return $this->respondValidationError($errors, 'Validation Error!');
        }

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return $this->respondWithData($product, 'Product created successfully', 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->respondWithError('Product not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = collect();
            foreach ($validator->errors()->getMessages() as $key => $value) {
                foreach ($value as $error) {
                    $errors->push($error);
                }
            }

            return $this->respondValidationError($errors, 'Validation Error!');
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return $this->respondWithData($product);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->respondWithError('Product not found', 404);
        }

        $product->delete();

        return $this->respondWithData([], 'Product deleted successfully');
    }
}
