<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Models\Worksheet;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Auth;

class RegisterOTService extends BaseService
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
        $TimeOT = $request->request_ot_time;

        $workSheet = Worksheet::where('member_id', Auth::id())->where('work_date', $requestForDate)->first();
        $actualOverTime = $workSheet->ot_time;

        $registerOT = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', $requestType)
            ->exists();

        if ($registerOT) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'Request already exists'
            ], 400);
        } elseif (strtotime($actualOverTime) < strtotime($TimeOT)) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'OT requirements cannot be greater than actual overtime'
            ], 400);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                'request_ot_time' => $TimeOT,
                'reason' => $reason,
            ];
            $this->create($data);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Create request success!'
            ], 200);
        }
    }

    public function show($request)
    {
        $requestForDate = trim($request->request_for_date);
        $registerOT = $this->model()->where('member_id', auth()->id())
            ->where('request_type', 5)
            ->where('request_for_date', $requestForDate)->first();

        if ($registerOT) {

            return $registerOT;
        } else {

            return response()->json([
                'status' => false,
                'code' => 204,
                'error' => 'This request is not available yet'
            ], 204);
        }
    }

    public function edit($request, $id)
    {
        $requestOT = $this->findOrFail($id);
        if ($requestOT->status == 0 && $requestOT->member_id == auth()->id()) {
            $requestForDate = $request->request_for_date;
            $requestType = $request->request_type;
            $reason = $request->reason;
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;
            $TimeOT = $request->request_ot_time;

            $workSheet = Worksheet::where('member_id', Auth::id())->where('work_date', $requestForDate)->first();
            $actualOverTime = $workSheet->ot_time;

            if (strtotime($actualOverTime) < strtotime($TimeOT)) {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'error' => 'OT requirements cannot be greater than actual overtime'
                ], 400);
            } else {
                $data = [
                    'member_id' => auth()->id(),
                    'request_type' => $requestType,
                    'request_for_date' => $requestForDate,
                    'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                    'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                    'request_ot_time' => $TimeOT,
                    'reason' => $reason,
                ];
                $this->update($id, $data);
                return response()->json([
                    'status' => true,
                    'code' => 201,
                    'message' => 'Update request success!'
                ], 201);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'You do not have permission to edit this request'
            ], 403);
        }
    }

    public function deleteOT($id)
    {
        $registerOT = $this->model()->where('member_id', Auth::id())->where('request_type', 5)->find($id);
        if ($registerOT) {
            $this->delete($id);
            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Delete request success!'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'This request is not available yet'
            ], 403);
        }
    }
}
