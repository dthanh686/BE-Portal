<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use App\Services\BaseService;

class NotificationService extends BaseService
{
    public function getRepository()
    {
        return NotificationRepository::class;
    }

}
