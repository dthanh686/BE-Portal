<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Repositories\RequestRepository;

class RegisterLateEarlyService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function store($request)
    {

    }
    

}
