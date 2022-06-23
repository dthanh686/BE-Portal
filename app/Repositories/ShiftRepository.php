<?php

namespace App\Repositories;

use App\Models\Shift;

class ShiftRepository extends BaseRepository
{

    public function getModel()
    {
        return Shift::class;
    }
}