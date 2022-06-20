<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterOTRequest;
use App\Services\RegisterOTService;
use Illuminate\Http\Request;

class RegisterOTController extends BaseController
{
    protected $registerOTService;

    public function __construct(RegisterOTService $registerOTService)
    {
        parent::__construct();
        $this->registerOTService = $registerOTService;
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterOTRequest $request)
    {
        return $this->registerOTService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RegisterOTRequest $request)
    {
        return $this->registerOTService->show($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterOTRequest $request, $id)
    {
        return $this->registerOTService->edit($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return  $this->registerOTService->deleteOT($id);
    }
}
