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
    public function index(Request $request)
    {
        // New Codes
        $user = $request->user();

        // // check if the user is admin or not
        if($user->role == 0) {
            // Get all Pizza orders (Admin)
            $pizzas = Pizza::orderBy('created_at', 'desc')->paginate(5);
        } else {
            // The user specific order
            $pizzas = Pizza::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        }

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
        // Get the authenticated user to add order
        $user = $request->user();

        $axiosdatas = $request->get('data');

        $inputvalues = array();

        foreach($axiosdatas as $i) {
            if($i != null){
                array_push($inputvalues, $i);
            }
        }

        $pizza = $request->isMethod('put') ? Pizza::findOrFail($inputvalues[5]) : new Pizza;


        if(count($inputvalues) == 6 ) {
            $pizza->id = $inputvalues[5];
            $pizza->user_id = $inputvalues[1];
            $pizza->customer_name = $inputvalues[2];
            $pizza->type = $inputvalues[3];
            $pizza->crust = $inputvalues[4];
        } else {
            $pizza->user_id = $inputvalues[0];
            $pizza->customer_name = $inputvalues[1];
            $pizza->type = $inputvalues[2];
            $pizza->crust = $inputvalues[3];
        }

        if($pizza->save()) {
            return new PizzaResource($pizza);
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
            return new PizzaResource($pizza);
        }
    }
}
