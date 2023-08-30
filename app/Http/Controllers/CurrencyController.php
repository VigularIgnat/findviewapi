<?php

namespace App\Http\Controllers;

use App\Models\currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorecurrencyRequest;
use App\Http\Requests\UpdatecurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecurrencyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecurrencyRequest $request, currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(currency $currency)
    {
        //
    }
}
