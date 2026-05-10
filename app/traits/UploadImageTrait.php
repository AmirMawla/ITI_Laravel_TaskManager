<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadImageTrait
{

    public function uploadImages(Request $request, $folder, $fieldname = 'image'): array
    {
        if (! $request->hasFile($fieldname)) {
            return [];
        }

        $files = $request->file($fieldname);
        $files = is_array($files) ? $files : [$files];

        $paths = [];

        foreach ($files as $file) {
            $path = $this->uploadFile($file, $folder);

            if ($path) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    public function uploadFile($file, $folder)
    {
        if (! $file instanceof UploadedFile || ! $file->isValid()) {
            return null;
        }

        $extension = $file->getClientOriginalExtension();
        $imageName = Str::uuid() . '.' . $extension;

        return $file->storeAs($folder, $imageName, 'public');
    }
}