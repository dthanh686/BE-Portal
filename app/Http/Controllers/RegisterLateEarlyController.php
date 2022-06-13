<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLateEarlyRequest;
use App\Services\RegisterLateEarlyService;
use Illuminate\Http\Request;

class RegisterLateEarlyController extends BaseController
{
    protected $registerLateEarlyService;

    public function __construct(RegisterLateEarlyService $registerLateEarlyService)
    {
        parent::__construct();
        $this->registerLateEarlyService  = $registerLateEarlyService;
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
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterLateEarlyRequest $request)
    {
        return $this->registerLateEarlyService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->registerLateEarlyService->show($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(RegisterLateEarlyRequest $request, $id)
    {
        return $this->registerLateEarlyService->edit($request,$id);
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
