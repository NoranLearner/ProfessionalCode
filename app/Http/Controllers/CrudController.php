<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller
{
    use OfferTrait;

    /* public function getOffers(){
        return Offer::select('id', 'name')->get();
    } */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request)
    {
        // validate data before insert to database
        /*  $rules = [
            'name' => 'required|max:100|unique:Offers,name',
            'price' => 'required|numeric',
            'details' => 'required'
        ]; */
        /* $messages = [
            // 'name.required' => 'اسم العرض مطلوب',
            'name.required' => __('messages.offernameRequired'),
            // 'name.unique' => 'اسم العرض موجود',
            'name.unique' => __('messages.offernameUnique'),
            // 'price.numeric' => 'سعر العرض يجب ان يكون ارقام',
            'price.numeric' =>  __('messages.offerpriceNumeric'),
        ]; */
        /* $rules = $this -> getRules();
        $messages = $this -> getMessages(); */
        /* $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator -> fails()) {
            //return $validator ->errors();
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        } */

        /*
        // save photo in folder
        $file_extension = $request -> photo -> getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = 'images/offers';
        $request -> photo -> move($path, $file_name);
        //return 'okay'; */
        // by Trait
        $file_name = $this -> saveImage($request -> photo , 'images/offers');

        // insert data from form to database
        Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' =>  $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
            'photo' => $file_name,
        ]);
        // return 'Saved Successfully';
        return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح']);
    }

    /* protected function getRules(){
        return $rules = [
            'name' => 'required|max:100|unique:Offers,name',
            'price' => 'required|numeric',
            'details' => 'required'
        ];
    }

    protected function getMessages(){
        return $messages = [
            'name.required' => 'اسم العرض مطلوب',
            'name.unique' => 'اسم العرض موجود',
            'price.numeric' => 'سعر العرض يجب ان يكون ارقام',
        ];
    } */

    public function getAllOffers()
    {
        $offers = Offer::select(
        'id',
        'name_'.LaravelLocalization::getCurrentLocale().' as name',
        'price' ,
        'details_'.LaravelLocalization::getCurrentLocale().' as details',
        ) -> get();
        return view('offers.all', compact('offers'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editOffer($offer_id)
    {
        //Offer::findOrFail($offer_id);
        $offer = Offer::find($offer_id);
        if (! $offer) {
            return redirect() -> back();
        }
        $offer = Offer::select('id', 'name_ar', 'name_en', 'price', 'details_ar', 'details_en') -> find($offer_id);
        return view('offers.edit', compact('offer'));

        // return $offer_id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOffer(OfferRequest $request, $offer_id)
    {
        //validation
        //check if offer exist
        $offer = Offer::find($offer_id);
        if (! $offer) {
            return redirect() -> back();
        }
        // update data
        $offer->update($request -> all());
        /* $offer->update([
            'name_ar' => $request -> name_ar,
            'name_en' => $request -> name_en,
            'price' => $request -> price,
        ]); */
        return redirect() -> back() ->with(['success' => 'تم التحديث بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
