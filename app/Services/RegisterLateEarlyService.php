<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Models\Worksheet;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Auth;

class RegisterLateEarlyService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function store($request)
    {
        $requestForDate = $request->request_for_date;
        $requestType = $request->request_type;
        $reason = $request->reason;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $compensationDate = $request->compensation_date;
        $compensationTime = $request->compensation_time;
        $month = date('Y-m', strtotime($requestForDate));

        $requestQuota = MemberRequestQuota::where('member_id', auth()->id())->where('month', $month)->first();
        $remain = $requestQuota->remain;

        $registerLateEarly = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', $requestType)
            ->exists();

        if ($registerLateEarly) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'Request already exists'
            ], 400);
        } elseif ($requestQuota->remain == 0) {
            return response()->json([
                'status' => false,
                'code' => 423,
                'error' => 'You have run out of requests for this month'
            ], 423);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                'compensation_date' => $compensationDate,
                'compensation_time' => $compensationTime,
                'reason' => $reason,
            ];
            $this->create($data);
            $requestQuota->remain = $remain - 1;
            $requestQuota->save();

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Create request success!'
            ], 200);
        }
    }

    public function show($id)
    {
        $request = $this->findOrFail($id);
        if ($request->member_id == auth()->id()) {
            return $request;
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'The request invalid'
            ], 403);
        }
    }

    public function edit($request, $id)
    {
        $requestLateEarly = $this->findOrFail($id);
        if ($requestLateEarly->status == 0 && $requestLateEarly->member_id == auth()->id()) {
            $requestForDate = $request->request_for_date;
            $requestType = $request->request_type;
            $reason = $request->reason;
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;
            $compensationDate = $request->compensation_date;
            $compensationTime = $request->compensation_time;

            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                'compensation_date' => $compensationDate,
                'compensation_time' => $compensationTime,
                'reason' => $reason,
            ];
            $this->update($id, $data);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Update request success!'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'You do not have permission to edit this request'
            ], 403);
        }
    }
}
