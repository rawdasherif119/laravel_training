<?php

namespace App\Traits;

use App\Image;
use App\File;
 
trait ManageFiles
{
    /**
     * Upload image in storage
     * @param  requested image & $model name
     * @return image url
     */
    public function UploadImage($image, $model)
    {
        return $image->store('uploads/'.$model.'', 'public');
    }

    /**
     * Upload file in storage
     * @param  requested file & $model name
     * @return file url
     */
    public function UploadFile($file, $model)
    {
        return $file->store('files/'.$model.'', 'public');
    }
    /**
     * Upload image in storage
     * @param  requested image & $model name
     * @return image url
     */
    public function UploadVideo($video, $model)
    {
        return $video->store('videos/'.$model.'', 'public');
    }

    /**
     * Get default image .
     *
     * @return default image url
     */
    public function DefaultImage()
    {
        return 'default.png';
    }

    /**
     * Retrieve uploaded and already stored files or images using ids
     * @param request
     * @return files
     */
    public function getStoredFiles($file, $request)
    {
        if ($file==$request->input('image')) {
            return Image::whereIn('id', $file)->get()->getDictionary();
        } elseif ($file==$request->input('file')) {
            return File::whereIn('id', $file)->get()->getDictionary();
        }
    }

    public function getStoredMedia($request)
    {
        if (isset($request->image_id)) {
            return Image::find($request->image_id);
        } elseif (isset($request->file_id)) {
            return File::find($request->file_id);
        }
    }
}
