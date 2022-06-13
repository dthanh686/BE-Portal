<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
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
        $perPage = $request->get('per_page') ?? config('common.default_page_size');

        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;

        $query = Notification::orWhereJsonContains('published_to', [$divisionId])->orWhereJsonContains('published_to', ["all"]);
        $orderBy = $request->get('sort');
        if ($orderBy) {
            $query->orderBy('published_date', $orderBy);
        }

        return $query->paginate($perPage);
    }
    public function view($id)
    {
        $member = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionName = $member->divisions->first()->division_name;
        $notice = Notification::findOrFail($id);
        $publishedTo = $notice->published_to;

        $array = [];
        if ($publishedTo != '["all"]') {
            foreach ($publishedTo as $val) {
                array_push($array, $val->division_name);
            }
        }

        if (in_array($divisionName, $array) || $publishedTo == '["all"]') {
            return new NotificationResource($notice);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'The request invalid'
            ], 403);
        }
    }
}
