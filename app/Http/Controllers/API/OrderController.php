<?php

namespace App\Http\Controllers\API;

use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Orders::latest()->paginate(15);
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
            'user_name' => 'required|string|max:191',
            'user_email' => 'required|string|max:191',
            'check_in' => 'required',
            'check_out' => 'required',
        ]);
        return Orders::create([
            'product_id' => $request['product_id'],
            'user_id' => $request['user_id'],
            'user_name' => $request['user_name'],
            'user_email' => $request['user_email'],
            'check_in' => $request['check_in'],
            'check_out' => $request['check_out'],
            'price' => $request['price'],
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return['message' => 'Order deleted'];
    }
}
