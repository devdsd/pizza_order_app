<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pizza;
use App\Http\Resources\Pizza as PizzaResource;

class PizzaController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Pizzas
        $pizzas = Pizza::orderBy('created_at', 'desc')->paginate(5);
        // $pizzas = Pizza::all();

        // return the collection of pizzas as a resource
        return PizzaResource::collection($pizzas);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
    public function create()
    {
        //
    }
    */

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $pizza = $request->isMethod('put') ? Pizza::findOrFail($request->pizza_id) : new Pizza;
        if($request->isMethod('put')) {
            $pizza = Pizza::findOrFail($request->pizza_id);
            $message = 'Updated Successfully!';
        } else {
            $message = '';
            $pizza = new Pizza;
        }
        // $pizza = $request->isMethod('put') ? Pizza::findOrFail($request->pizza_id) : new Pizza;

        $pizza->id = $request->input('pizza_id');
        $pizza->customer_name = $request->input('customer_name');
        $pizza->type = $request->input('type');
        $pizza->crust = $request->input('crust');

        if($pizza->save()) {
            if($message) {
                return response(['data' => new PizzaResource($pizza), 'message' => $message, 'author' => 'Diether Dayondon']);
            } else {
                return new PizzaResource($pizza);
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get a Specified Pizza Order
        $pizza = Pizza::findOrFail($id);

        // Return the specified pizza order
        return new PizzaResource($pizza);
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function edit($id)
    {
        //
    }
    */

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function update(Request $request, $id)
    {
        //
    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get a Specified Pizza Order
        $pizza = Pizza::findOrFail($id);

        // Delete the spicific pizza order
        if($pizza->delete()) {
            return response(['data' => new PizzaResource($pizza), 'message' => 'Deleted Successfully!', 'author' => 'Diether Dayondon']);
        }
    }
}
