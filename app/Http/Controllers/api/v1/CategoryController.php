<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return $this->respondWithError('No categories found', 404);
        }

        return $this->respondWithData($categories);
    }

    public function createCategory(Request $request)
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

        $category = Category::create([
            'name' => $request->name,
        ]);

        return $this->respondWithData($category, 'Category created successfully', 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->respondWithError('Category not found', 404);
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

        $category->update([
            'name' => $request->name,
        ]);

        return $this->respondWithData($category);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->respondWithError('Category not found', 404);
        }

        $category->delete();

        return $this->respondWithData([], 'Category deleted successfully');
    }
}
