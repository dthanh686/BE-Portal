<?php

namespace App\Services;

use App\Http\Resources\MemberShiftResource;
use App\Models\MemberShift;
use App\Models\Shift;
use App\Repositories\MemberShiftRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class MemberShiftService extends BaseService
{
    public function getRepository()
    {
        return MemberShiftRepository::class;
    }

    public function listMemberShift($request)
    {
        $memberShift = $this->model()->get();
        $fullName = trim($request->member_name);
        if ($fullName) {
            $memberShift = MemberShift::join('members', 'member_shift.member_id', 'members.id')->where('full_name', 'like', "%$fullName%")->get();
        }

        return MemberShiftResource::collection($memberShift);
    }

    public function updateShift($request, $id)
    {
        $memberShift = $this->findOrFail($id);
        $ShiftId = $request->shift_id;
        if ($memberShift) {
            $data = [
                'shift_id' => $ShiftId,
            ];
            $this->update($id, $data);
            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Update shift success!'
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
