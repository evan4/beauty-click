<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\{Request, Response};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credentials = request([ 'page', 'sortBy', 'sortDesc']);
        
        $orderBy = $credentials['sortBy'];
        $sortDesc = (bool) $credentials['sortDesc'] ? 'asc' : 'desc';
        
        $categories = Category::orderBy($orderBy, $sortDesc)
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'categories' => $categories,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->toArray();

        $validator = Validator::make($input, [
            'title' => ['required', 'string', 'max:255'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], Response::HTTP_OK);
        }

        $category =  Category::create([
            'title' => $input['title'],
            'slug' => Str::slug($input['title']),
            'description' => $input['description'],
        ]);
        
        if($category){
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->toArray();

        $validateArray = [
          'title' => ['required', 'string', 'max:255'],
        ];

        $data = [
            'title' => $input['title'],
            'slug' => Str::slug($input['title']),
            'description' => $input['description'],
        ];

        $validator = Validator::make($data, $validateArray);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], Response::HTTP_OK);
        }

        $category->update($data);

        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $res = $category->delete();
        
        if($res){
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
        ], Response::HTTP_OK);
        
    }
    
}
