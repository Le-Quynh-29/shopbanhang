<?php

namespace App\Repositories;

use App\Repositories\Support\AbstractRepository;
use App\Traits\LogTrait;
use App\Traits\StorageTrait;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use App\Models\Attachment;
use FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Exception;

class AttachmentRepository extends AbstractRepository
{

    use StorageTrait, LogTrait;

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return 'App\Models\Attachment';
    }

    /**
     * Create attachment
     *
     * @return void
     */
    public function createAttachment($file, $entityType, $entityId)
    {
        // Get name, size, contents, ext, path file
        $name = $file->getClientOriginalName();
        $size = $file->getSize() / 1024;
        $ext = $file->getClientOriginalExtension();
        $path = $this->storageUploadAttachment($entityType, $entityId, $file);
        $pos = $this->getMaxPosWithEntityType($entityType, $entityId);
        $url = url('/') . '/attachment/' . $path;

        $data = [
            'name' => $name,
            'ext' => $ext,
            'size' => $size,
            'path' => $path,
            'pos' => $pos + 1,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'user_id' => Auth::id()
        ];

        $attachment = Attachment::create($data);
        // Create log when create
        $event = 'cập nhật tài liệu đính kèm '.$entityType;
        $data = [
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'file_local' => $url
        ];
        $this->createLog($event, $data);
        return $attachment;
    }

    /**
     * Delete attachment
     *
     * @param mixed $attachmentId
     * @return void
     */
    public function deleteAttachment($attachmentId)
    {
        $attachment = Attachment::findOrFail($attachmentId);

        if ($attachment) {
            $attachmentType = $attachment->type;
            $entityType = $attachment->entity_type;
            $entityId = $attachment->entity_id;
            $attachmentPos = $attachment->pos;
            $path = $attachment->path;
            // Delete attachment into dist storage
            $this->storageDeleteAttachment(base64_decode($path));

            // Update pos
            Attachment::where('entity_type', $entityType)
                ->where('entity_id', $entityId)
                ->where('type', $attachmentType)
                ->where('pos', '>', $attachmentPos)
                ->decrement('pos', 1);
            // Create log when delete
            $event = 'cập nhật tài liệu đính kèm '.$entityType;
            $data = [
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'file_local' => $attachment->url
            ];
            $this->createLog($event, $data);

            $attachment->delete();
        }
    }

    /**
     * Get max pos with entity type
     *
     * @return void
     */
    public function getMaxPosWithEntityType($entityType, $entityId)
    {
        return Attachment::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->max('pos');
    }

    /**
     *
     * @param string $entityType
     * @param integer $entityId
     */
    public function getAttachmentsByEntityAndType($entityType, $entityId)
    {
        return Attachment::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderBy('pos')
            ->get();
    }

    /**
     * Get content of file.
     * @param int $storyId
     * @param string $base64Entry
     * @return array
     */
    public function responseFile($path)
    {
        $pathDecoded = storage_path('app' . base64_decode($path));
        $file = File::get($pathDecoded);
        $mineType = File::mimeType($pathDecoded);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $mineType);

        return $response;
    }

    /**
     * detach attachment by entity
     *
     * @param mixed $entityType
     * @param mixed $entityId
     * @return void
     */
    public function detachAttachmentByEntity($entityType, $entityId)
    {
        Attachment::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->delete();
    }

    /**
     * get attachment by entity
     *
     * @param mixed $entityType
     * @param mixed $entityId
     * @return void
     */
    public function getAttachmentByEntity($entityType, $entityId)
    {
        return Attachment::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderBy('id')
            ->get();
    }
}
