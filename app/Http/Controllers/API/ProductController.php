<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        
        return Product::with(['reservation'])->latest()->paginate(10);
    }

    public function items()
    {
        return ProductResource::collection(Product::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'price' => 'required|integer|min:1',
            'category' => 'required',
            'description' => 'required|string|max:191',
            'capacity' => 'required|integer|min:1',
            'size' => 'required|integer|min:3'
        ]);
        
        $exploded  = explode(',', $request->image);  // your base64 encoded
        $decoded = base64_decode($exploded[1]);
        if(Str::contains($exploded[0],'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileName = Str::random().'.'.$extension;
        $path = public_path().'/img/products/'.$fileName;
        file_put_contents($path, $decoded);   

        return Product::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'category' => $request['category'],
            'description' => $request['description'],
            'image' => $fileName,
            'capacity' => $request['capacity'],
            'size' => $request['size'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return new ProductResource($product);
    }

    
    public function showNew() {
        
        return Product::latest()->paginate(5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
    
        $exploded  = explode(',', $request->image);  // your base64 encoded
        $decoded = base64_decode($exploded[1]);
        if(Str::contains($exploded[0],'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileName = Str::random().'.'.$extension;
        $path = public_path().'/img/products/'.$fileName;
        file_put_contents($path, $decoded);   

        
        $request->merge(['image' => $fileName]);
        
        $product = update($request->all());
        return ['message' => 'Updated product info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete(); 
        return ['message' => 'Product deleted'];

    }

    public function showReservations(Product $product) 
    {
        return $product->reservation()->latest()->paginate(10);
    }

    
    public function category(Request $request) 
    {
        $category = $request->get('q');
        return Product::where('category', 'like', '%'.$category.'%')->latest()->paginate(5);
    }

    public function search(Request $request) {
        $search = $request->get('q');
        return Product::where('name', 'like', '%'.$search.'%')->latest()->get();
    }
}
