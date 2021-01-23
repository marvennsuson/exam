<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Validator;
use Faker;
use Redirect,Response;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $custom =  Customer::inRandomOrder()->get();

       return response()->json(['status' => true, 'data'=> $custom]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             $faker = Faker\Factory::create();
        //

        // $faker = Faker\Factory::create();
        //
        //
        //     for($i = 0 ; $i < 5 ; $i++){
        //       Customer::create(
        //           [
        //               'cid' => $faker->randomElement($array = array ('1','2','3')),
        //               'name' =>  $faker->realText($maxNbChars = 5, $indexSize = 5),
        //               'email' => $faker->safeEmail ,
        //           ]
        //       );
        //           for ($i=5; $j > $i ; $j++) {
        //             Company::create(
        //                 [
        //
        //                     'title' =>  $faker->realText($maxNbChars = 5, $indexSize = 5),
        //                     'description' => $faker->text
        //                 ]
        //             );
        //           }
        //     }
        // dd($request->all());
        $validator =Validator::make($request->all(),[

           'value' => 'required',

        ]);

        if ($validator->fails()) {
           return response()->json(['status' => false, 'msg'=>$validator->errors()]);
        }else{

              $data = [
                 'cid' =>  $faker->randomElement($array = array ('1','2','3')),
                 'name' => $request->value,
                 'email' => $faker->safeEmail,

              ];

              try {
                 Customer::create($data);
              } catch (\Throwable $th) {
                 $response = ['status' => false, 'msg' => $th];
                 return response()->json($response);
              }
           }




        $response = ['status' => true, 'msg' => 'Generate User Successfully'];
        return response()->json($response);


    }


public function viewAll(){
  $custom =  Customer::all();
  dd($custom);
 return response()->json(['status' => true, 'data'=> $custom]);
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //


    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
