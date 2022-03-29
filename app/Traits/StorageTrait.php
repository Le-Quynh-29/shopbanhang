<?php

namespace App\Traits;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Image;
use Illuminate\Support\Facades\File;

trait StorageTrait
{
    /**
     * Upload attachment of article
     * @param string $entityType
     * @param integer $entityId
     * @param File $attachment
     * @return string
     */
    public function storageUploadAttachment($entityType, $entityId, $attachment)
    {
        $this->createFolder($entityType, $entityId);
        $parentPath = '/'.$entityType . '/' . $entityId . '/';
        $encodeFilename = time() . '_' . sha1($attachment->getClientOriginalName()) . '.' . $attachment->getClientOriginalExtension();
        try {
            Storage::disk('local')->putFileAs($parentPath, $attachment, $encodeFilename);
        } catch (RunTimeException $e) {
            dd($e->getMessage());
        }
        return base64_encode($parentPath . $encodeFilename);
    }

    /**
     * Import attachment into storage
     * @param string $entityType
     * @param integer $entityId
     * @param string $importAttachmentPath
     * @param string $importAttachmentName
     * @return mixed
     */
    public function storageImportAttachment($entityType, $entityId, $importAttachmentPath, $importAttachmentName)
    {
        $this->createFolder($entityType, $entityId);
        $parentPath = storage_path('app' .$entityType ) . '/' . $entityId . '/';
        $storageAttachmentPath = $parentPath . $importAttachmentName;
        File::copy($importAttachmentPath, $storageAttachmentPath);
        $this->storageSetPermission($storageAttachmentPath);
        return base64_encode( '/'.$entityType . '/' . $entityId . '/' . $importAttachmentName);
    }

    /**
     * Delete a attachment
     * @param string $attachmentPath
     */
    public function storageDeleteAttachment($attachmentPath)
    {
        // Check if file exists in storage
        if (!Storage::disk('local')->exists($attachmentPath)) {
            return;
        }
        // Process to delete file
        try {
            Storage::delete($attachmentPath);
        } catch (RunTimeException $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Create a article folder
     * @param string $entityType
     * @param integer $entityId
     */
    private function createFolder($entityType, $entityId)
    {
        try {
            Storage::disk('local')->makeDirectory('/'. $entityType . '/' . $entityId);
        } catch (RunTimeException $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Upload image of category
     * @param File $image
     * @return string
     */
    public function storageUploadImage($image)
    {

        if (is_null($image)) {
            return $image;
        }

        $encodeFilename = time() . '_' . sha1($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

        try {
            // Resize cover with max width, max height
            $imageSizes = Attachment::COVER_RESIZES;
            foreach ($imageSizes as $size) {
                $width = $size['width'];
                $height = $size['height'];
                $parentPath = $size['path'];
                $path = $parentPath . $encodeFilename;
                // Resize
                $resize = Image::make($image);
                $resize->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');

                Storage::disk('public')->put($path, $resize);
            }
        } catch (RunTimeException $e) {
            dd($e->getMessage());
        }

        return base64_encode($encodeFilename);
    }


    /**
     * Import file into storage
     * @param type $srcFile
     * @param type $desFile
     */
    public function storageImportFile($srcFile, $desFile)
    {
        File::copy($srcFile, $desFile);
        $this->storageSetPermission($desFile);
    }

    /**
     * Setting permission for file in storage
     * @param type $path
     */
    private function storageSetPermission($path)
    {
        chmod($path, 0777);
    }
}
