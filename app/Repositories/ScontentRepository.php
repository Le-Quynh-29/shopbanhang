<?php

namespace App\Repositories;

use App\Repositories\Support\AbstractRepository;
use Illuminate\Support\Facades\Storage;

class ScontentRepository
{

    /**
     * Get content of file.
     * @param int $storyId
     * @param string $base64Entry
     * @return array
     */
    public function responseFile($path)
    {
        $pathDecoded = base64_decode($path);

        if (!Storage::disk('public')->exists($pathDecoded)) {
            abort(404);
        }
        return Storage::disk('public')->response($pathDecoded);
    }

}
