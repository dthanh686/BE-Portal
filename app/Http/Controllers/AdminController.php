<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\RequestResource;
use App\Services\MemberShiftService;
use App\Services\NotificationService;
use App\Services\RequestService;
use App\Services\ShiftService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    protected $requestService;
    protected $notificationService;
    protected $memberShiftService;
    protected $shiftService;
    public function __construct(ShiftService $shiftService,MemberShiftService $memberShiftService, RequestService $requestService, NotificationService $notificationService)
    {
        parent::__construct();
        $this->middleware('auth.admin');
        $this->requestService = $requestService;
        $this->notificationService = $notificationService;
        $this->memberShiftService = $memberShiftService;
        $this->shiftService = $shiftService;
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

    public function listNotifications(Request $request)
    {
        return $this->notificationService->listNoticeAdmin($request);
    }

    public function updateStatusNotice(Request $request, $id)
    {
        return $this->notificationService->updateNoticeAdmin($request, $id);
    }

    public function deleteNotifications($id)
    {
        return $this->notificationService->deleteNotice($id);
    }

    public function listMemberShift(Request $request)
    {
        return $this->memberShiftService->listMemberShift($request);
    }

    public function updateMemberShift(Request $request, $id)
    {
        return $this->memberShiftService->updateShift($request, $id);
    }

    public function listShift()
    {
        return $this->shiftService->listShift();
    }
    
}
