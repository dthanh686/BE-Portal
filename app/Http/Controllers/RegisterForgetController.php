<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterForgetRequest;
use App\Services\RegisterForgetService;
use http\Env\Response;
use Illuminate\Http\Request;

class RegisterForgetController extends BaseController
{
    protected $registerForgetService;

    public function __construct(RegisterForgetService $registerForgetService)
    {
        parent::__construct();
        $this->registerForgetService = $registerForgetService;
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
    public function store(RegisterForgetRequest $request)
    {
        return $this->registerForgetService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->registerForgetService->show($id);
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
     * @param RegisterForgetRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegisterForgetRequest $request, $id)
    {
        $result = $this->registerForgetService->edit($request,$id);
        if ($result == 1) {
            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Update request success!'
            ], 201);
        } else {
            return \response()->json([
                'status' => 'error',
                'code' => 422,
                'error' => 'Something went wrong or please check again!'
            ], );
        }
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
