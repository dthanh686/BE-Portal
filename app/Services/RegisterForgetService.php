<?php

namespace App\Services;

use App\Repositories\RequestRepository;

class RegisterForgetService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function store($request)
    {
        $model = $this->model();
        $requestForDate = trim($request->request_for_date);
        $requestType = $request->request_type;
        $checkin = trim($request->check_in);
        $checkout = trim($request->check_out);
        $reason = trim($request->reason);
        $registerForget = $model->where('member_id', auth()->id())
                         ->where('request_type', $requestType)
                         ->where('request_for_date', $requestForDate)
                         ->exists();
        if ($registerForget) {
            return response()->json([
                'status' => 'error',
                'code' => 423,
                'error' => 'Request already exists'
            ], 423);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $request->request_type,
                'request_for_date' => $request->request_for_date,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
            ];
            return $this->create($data);
        }
    }

    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function edit($request, $id)
    {
        $requestForget = $this->findOrFail($id);
        if ($requestForget->status == 0) {
            $requestForDate = trim($request->request_for_date);
            $requestType = $request->request_type;
            $checkin = trim($request->check_in);
            $checkout = trim($request->check_out);
            $reason = trim($request->reason);
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $request->request_type,
                'request_for_date' => $request->request_for_date,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
            ];
            return $this->update($id, $data);
        } else {
            dd($requestForget->status);
        }
     }
}
