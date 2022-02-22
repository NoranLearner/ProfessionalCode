<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Models\Video;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class OfferController extends Controller
{
    use OfferTrait;

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
        //view form to add this offer
        return view('ajaxoffers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //save offer into database using ajax
        // by Trait
        $file_name = $this -> saveImage($request -> photo , 'images/offers');

        // insert data from form to database
        $offer = Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' =>  $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
            'photo' => $file_name,
        ]);
        // return 'Saved Successfully';
        // return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح']);
        if ($offer) {
            return response() -> json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
            ]);
        } else {
            return response() -> json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }

    public function all()
    {
        $offers = Offer::select(
            'id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'price' ,
            'details_'.LaravelLocalization::getCurrentLocale().' as details',
            'photo',
            ) -> limit(10) -> get();
            return view('ajaxoffers.all', compact('offers'));
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
    public function edit(Request $request)
    {
        $offer = Offer::find($request -> offer_id);
        if (! $offer) {
            return response() -> json([
                'status' => false,
                'msg' => 'هذا العرض غير موجود',
            ]);
        }
        $offer = Offer::select('id', 'name_ar', 'name_en', 'price', 'details_ar', 'details_en') -> find($request -> offer_id);
        return view('ajaxoffers.edit', compact('offer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // return $request;

        //validation
        //check if offer exist
        $offer = Offer::find($request -> id);
        if (! $offer) {
            return redirect() -> back() -> with(['error' => __('messages.OfferNotExist')]);
        }

        //Delete Data
        $offer -> delete();
        //return redirect() -> route('offers-all') -> with(['success' => __('messages.DeleteOffer')]);
        return response() -> json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح',
            'id' => $request -> id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validation
        //check if offer exist
        $offer = Offer::find($request -> offer_id);
        if (! $offer) {
            return response() -> json([
                'status' => false,
                'msg' => 'هذا العرض غير موجود',
            ]);
        }
        // update data
        $offer->update($request -> all());
        /* $offer->update([
            'name_ar' => $request -> name_ar,
            'name_en' => $request -> name_en,
            'price' => $request -> price,
        ]); */
        return response() -> json([
            'status' => true,
            'msg' => 'تم التحديث بنجاح',
        ]);
    }

}
