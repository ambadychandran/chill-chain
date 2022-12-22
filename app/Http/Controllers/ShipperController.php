<?php

namespace App\Http\Controllers;

use App\Models\Shipper;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippers = Shipper::all(['id','name','address']);

        $shippers = $shippers->each(function($item, $key) {
            $item->contacts = Contacts::where('shipper_id', '=', $item->id)->get();
            $item->primary =  $item->contacts->firstWhere ('primary', '1');
        });

        return response()->json($shippers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //shipper array
        $shipper_details = $request->shipper;

        //Shipepr data
        $shipper_data = array_slice($shipper_details, 0,2);

        //'primary conacts
        $primary_conacts = array_splice($shipper_details, -2);
        $primary_conacts['primary']="1";

        //contacts array
        $contact_details = $request->contact;
        $contact_details[] = $primary_conacts;

        //Save shipper
        $shipper = Shipper::create($shipper_data);

        //save contacts
        foreach ($contact_details as $contact) {
            Contacts::create([
                'name' =>  $contact['cname'],
                'number' => $contact['cnumber'],
                'shipper_id' => $shipper->id,
                'primary' => (isset($contact['primary']) && $contact['primary'] == "1") ? $contact['primary'] :0 ,
            ]);
        }

        return response()->json([
            'message'=>'shipper Created Successfully!!',
            'shipper'=>$shipper
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function show(Shipper $shipper)
    {

        $shipper->contacts = Contacts::where('shipper_id', $shipper->id)->get();
        $shipper->primary =  $shipper->contacts->firstWhere ('primary', '1');
        $shipper->contacts = $shipper->contacts->where('primary', '!=', '1');

        return response()->json($shipper);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipper  $shipper
     * @param  \App\Models\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipper $shipper,Contacts $contacts)
    {

        $shippers = array(
                        "name" => $request->name,
                        "address" => $request->address,
                    );
        $contacts_arr =$request->contacts;
        $contacts_arr[] =$request->primary;
        //update contacts
        foreach ($contacts_arr as $values) {
            $filtered = Arr::only($values,['name','number','shipper_id','primary']);
            Contacts::whereId($values['id'])->update($filtered);
        }

        $shipper->fill($shippers)->save();
        return response()->json([
            'message'=>'Shipper Updated Successfully!!',
            'shipper'=>$shipper
        ]);
    }
}
