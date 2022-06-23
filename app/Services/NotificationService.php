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

    public function listNoticeAdmin($request)
    {
        $perPage = $request->get('per_page') ?? config('common.default_page_size');
        $notifications = $this->model()->where('status',1)->paginate($perPage);

        return NotificationResource::collection($notifications);
    }
    public function updateNoticeAdmin($request, $id)
    {
        $notice = $this->findOrFail($id);
        $status = $request->status;
        if ($notice->status === 0) {
            $data = [
                'status' => $status,
            ];
            $this->update($id, $data);
            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Confirm request success!'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'This request is not available yet'
            ], 403);
        }
    }

    public function store($data)
    {
        $notifications = Notification::create($data->all());

        if ($data->hasFile('attachment')) {
            $newFileName = uniqid() . '-' . $data->attachment->getClientOriginalName();
            $filePath = $data->attachment->storeAs(config('common.default_file_path') . 'notifications', $newFileName);
            $notifications->attachment = 'http://18.141.177.206/storage' . str_replace('public', '', $filePath);
        }
        $notifications->save();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Create request success!'
        ], 200);
    }

    public function listNotifications($request)
    {
        $perPage = $request->get('per_page') ?? config('common.default_page_size');

        $member = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $member->divisions->first()->id;
       
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

    public function deleteNotice($id)
    {
        $notice = $this->model()->find($id);
        if ($notice) {
            $this->delete($id);
            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Delete notice success!'
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
