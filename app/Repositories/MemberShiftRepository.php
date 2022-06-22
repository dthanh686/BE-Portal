<?php

namespace App\Repositories;

use App\Models\MemberShift;

class MemberShiftRepository extends BaseRepository
{

    public function getModel()
    {
        return MemberShift::class;
    }
}