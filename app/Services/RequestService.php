<?php

namespace App\Services;

use App\Models\LeaveQuota;
use App\Models\MemberRequestQuota;
use App\Models\Worksheet;
use App\Repositories\RequestRepository;

class RequestService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function getRequestSent() {
        $requestSent = $this->model()->where('status', 0)->get();
        return $requestSent;
    }

    public function confirm($request, $id)
    {
        $requestSent = $this->findOrFail($id);
        if ($requestSent->status === 0) {
            $status = $request->status;
            $comment = trim($request->comment);
            $memberId = $requestSent->member_id;
            $date = $requestSent->request_for_date;
            $requestType = $requestSent->request_type;
            $note = config('common.note_confirm');
            $month = date('Y-m', strtotime($date));



            $worksheet = Worksheet::where('member_id', $memberId)->where('work_date', $date)->first();

            $data = [
                'status' => $status,
                'manager_confirmed_comment' => $comment,
                'manager_confirmed_at' => now(),
                'manager_confirmed_status' => 1,
            ];

            $this->update($id, $data);

            if ($status == 1) {
                $worksheet->note = $note[$requestType];
                $worksheet->save();
            } else {
                if ($requestType == 1 || $requestType == 4) {
                    $requestQuota = MemberRequestQuota::where('member_id', $memberId)->where('month', $month)->first();
                    $requestQuota->remain = $requestQuota->remain + 1;
                    $requestQuota->save();
                } elseif ($requestType == 2) {
                    $year = date('Y', strtotime($date));
                    $leaveAllDay = $requestSent->leave_all_day;
                    $leaveTime = $requestSent->leave_time;
                    $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);

                    $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();

                    $leaveQuota->remain = $leaveQuota->remain + $timeLeave;
                    $leaveQuota->paid_leave =  $leaveQuota->paid_leave - $timeLeave;
                    $leaveQuota->save();
                } elseif ($requestType == 3) {
                    $year = date('Y', strtotime($date));
                    $leaveAllDay = $requestSent->leave_all_day;
                    $leaveTime = $requestSent->leave_time;
                    $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);

                    $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();

                    $leaveQuota->unpaid_leave = $leaveQuota->unpaid_leave - $timeLeave;
                    $leaveQuota->save();
                }

            }

            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Confirm request success!'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'You are not authorized to process this request'
            ], 403);
        }
    }

    public function getRequestConfirm() {
        $requestConfirm = $this->model()->where('status', 1)->get();
        return $requestConfirm;
    }

    public function approve($request, $id)
    {
        $requestConfirm = $this->findOrFail($id);
        if ($requestConfirm->status === 1) {
            $status = $request->status;
            $comment = trim($request->comment);

            $memberId = $requestConfirm->member_id;
            $checkIn = $requestConfirm->check_in;
            $checkOut = $requestConfirm->check_out;
            $date = $requestConfirm->request_for_date;
            $requestType = $requestConfirm->request_type;
            $note = config('common.note_approve');
            $errorCount = $requestConfirm->error_count;
            $month = date('Y-m', strtotime($date));

            $worksheet = Worksheet::where('member_id', $memberId)->where('work_date', $date)->first();

            $data = [
                'status' => $status,
                'manager_confirmed_comment' => $comment,
                'manager_confirmed_at' => now(),
                'manager_confirmed_status' => 1,
            ];

            $this->update($id, $data);
            if ($status === 2) {
                $worksheet->note = $note[$requestType];
                $worksheet->save();
                if ($errorCount != 0) {
                    $requestQuota = MemberRequestQuota::where('member_id', $memberId)->where('month', $month)->first();
                    $requestQuota->remain = $requestQuota->remain + 1;
                    $requestQuota->save();
                }
            } else {
                $worksheet->note = null;
                $worksheet->save();
                if ($requestType == 1 || $requestType == 4) {
                    $requestQuota = MemberRequestQuota::where('member_id', $memberId)->where('month', $month)->first();
                    $requestQuota->remain = $requestQuota->remain + 1;
                    $requestQuota->save();
                } elseif ($requestType == 2) {
                    $year = date('Y', strtotime($date));
                    $leaveAllDay = $requestConfirm->leave_all_day;
                    $leaveTime = $requestConfirm->leave_time;
                    $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);

                    $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();

                    $leaveQuota->remain = $leaveQuota->remain + $timeLeave;
                    $leaveQuota->paid_leave =  $leaveQuota->paid_leave - $timeLeave;
                    $leaveQuota->save();
                } elseif ($requestType == 3) {
                    $year = date('Y', strtotime($date));
                    $leaveAllDay = $requestConfirm->leave_all_day;
                    $leaveTime = $requestConfirm->leave_time;
                    $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);

                    $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();

                    $leaveQuota->unpaid_leave = $leaveQuota->unpaid_leave - $timeLeave;
                    $leaveQuota->save();
                }
            }

            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Confirm request success!'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'You are not authorized to process this request'
            ], 403);
        }
    }

    public function show($request)
    {
        $requestForDate = trim($request->request_for_date);
        $requests = $this->model()->where('member_id', auth()->id())->where('request_for_date', $requestForDate);
        if ($requests->exists()){
            return $requests->first();
        } else {
            return response()->json([
                'status' => false,
                'code' => 204,
                'error' => 'This request is not available yet'
            ], 204);
        }
    }
}
