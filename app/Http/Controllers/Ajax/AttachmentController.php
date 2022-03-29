<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\AjaxController;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;

class AttachmentController extends AjaxController
{
    protected $attachmentRepo;

    public function __construct(AttachmentRepository $attachmentRepo)
    {
        $this->attachmentRepo = $attachmentRepo;
    }

    /**
     * Upload document article
     *
     * @param  mixed $request
     * @return void
     */
    public function upload(Request $request)
    {
        return $this->responseSuccess('success');
    }

    /**
     * Upload document type local
     *
     * @param  mixed $request
     * @return void
     */
    public function uploadLocal(Request $request)
    {
        set_time_limit(20);
        $file = $request->file('file');
        $entityType = $request->get('entity_type');
        $entityId = $request->get('entity_id');

        $file = $this->attachmentRepo->createAttachment($file, $entityType, $entityId);
        return $this->responseSuccess($file);
    }

    /**
     * Delete attachment
     *
     * @param  mixed $request
     * @return void
     */
    public function deleteAttachment(Request $request)
    {
        $id = $request->get('id');
        $this->attachmentRepo->deleteAttachment($id);
        return $this->responseSuccess('success');
    }
}
