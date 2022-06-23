<?php

namespace App\Services;

use App\Http\Resources\ShiftResource;
use App\Models\MemberShift;
use App\Models\Shift;
use App\Repositories\ShiftRepository;
use App\Services\BaseService;

class ShiftService extends BaseService
{
    public function getRepository()
    {
        return ShiftRepository::class;
    }

    public function listShift()
    {
        $shifts = $this->model()->get();

        return ShiftResource::collection($shifts);
    }

   
}
