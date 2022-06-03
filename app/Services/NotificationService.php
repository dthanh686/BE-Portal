<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;


class NotificationService extends BaseService
{
    public function getRepository()
    {
        return NotificationRepository::class;
    }

    public function listNotifications($request)
    {
        $limit = $request->get('limit') ?? config('common.default_page_size');
        $orderBy = $request->get('sort');
        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;
        $query = Notification::whereJsonContains('published_to', [$divisionId]);

        if ($orderBy) {
            $query->orderBy('id', $orderBy);
        }

        return $query->paginate($limit);
    }
}
