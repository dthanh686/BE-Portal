<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\RequestResource;
use App\Services\NotificationService;
use App\Services\RequestService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    protected $requestService;
    protected $notificationService;
    public function __construct(RequestService $requestService, NotificationService $notificationService)
    {
        parent::__construct();
        $this->middleware('auth.admin');
        $this->requestService = $requestService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        return $this->requestService->getRequestConfirm();
    }

    public function update(ApproveRequest $request, $id)
    {
        return $this->requestService->approve($request, $id);
    }

    public function createNotifications(NotificationRequest $request)
    {
        return $this->notificationService->store($request);
    }

    public function listNotifications()
    {
        return $this->notificationService->listNoticeAdmin();
    }

    public function updateStatusNotice(NotificationRequest $request, $id)
    {
        return $this->notificationService->updateNoticeAdmin($request, $id);
    }
}
