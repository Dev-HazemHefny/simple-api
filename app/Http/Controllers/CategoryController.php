<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiHandler;
use App\Models\Category;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class CategoryController extends Controller
{
    use ApiHandler;
    public function create(Request $request)
    {
        $category = Category::create([
            'name_en' => $request->name_en,
            'name_ar' =>$request->name_ar,
        ]);
        if(!$category)
        {
            return $this->errorMessage('error during creating');
        }
        return $this->successMessage('data added successfully');
    }
    public function getAll(Request $request)
    {
        $categories = Category::select("id","name_".app()->getLocale())->get();
        
        if($categories)
        {
            return response()->json(['message' => $categories]);
        }
        return response()->json(['message'=>'no data found']);
    }
    public function update(Request $request)
    {
        $updated = Category::where("id",$request->id)->update([
            'name_ar' =>$request->name_ar,
            'name_en' =>$request->name_en,
        ]);
        if($updated)
        {
            return response()->json(['message' => 'data updated succefully']);
        }
        return response()->json(['message' => 'error']);
    }
    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        if($category)
        {
            $category->delete();
            return response()->json(['message'=>'data deleted']);
        }
        return response()->json(['message'=>'error while deleting']);
    }
    public function getCategById(Request $request)
    {
        $category = Category::where("id",$request->id)->get();
        if($category)
        {
            return response()->json(['message'=>$category]);            
        }
        return response()->json(['message'=>'element not found']);
    }
}
