<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rating;
use App\Http\Resources\Rating as RatingResources;

class DetailController extends Controller
{
    public function show($id) 
    {
        return RatingResources::collection(Rating::where('product_id', $id)->latest()->get());
    }

    public function detail($id) 
    {
        return view('detail');
    }

    public function store(Request $request) 
    {
        
        $this->validate($request, [
            'rating' => 'required|min:1',
            'short_description' => 'required|string|min:4',
            'comment' => 'required|string|min:10'
        ]);

        return Rating::create([
            'product_id' => $request->get('product_id'),
            'user_id' => $request->get('user_id'),
            'user_name' => $request->get('user_name'),
            'rating' => $request->get('rating'),
            'short_description' => $request->get('short_description'),
            'comment' => $request->get('comment')
        ]);

    }

    
    public function destroy($id)
    {
        $product = Rating::findOrFail($id);
        $product->delete();
        return ['message' => 'Product deleted'];
    }

    
}
