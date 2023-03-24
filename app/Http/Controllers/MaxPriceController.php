<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaxPriceRequest;
use App\Http\Requests\UpdateMaxPriceRequest;
use App\Models\MaxPrice;

class MaxPriceController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMaxPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaxPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaxPrice  $maxPrice
     * @return \Illuminate\Http\Response
     */
    public function show(MaxPrice $maxPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaxPrice  $maxPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(MaxPrice $maxPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaxPriceRequest  $request
     * @param  \App\Models\MaxPrice  $maxPrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaxPriceRequest $request, MaxPrice $maxPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaxPrice  $maxPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaxPrice $maxPrice)
    {
        //
    }
}
