<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use App\File;
use App\Folder;
use App\Traits\ManageFiles;
use App\Traits\ModelInstance;

class FilesController extends Controller
{
    use ManageFiles,ModelInstance;

    public function store(Request $request)
    {
        $url = $this->Upload($request, $this->getModelName($request));
        $file =File::create(['file'=>$url]);
        return response()->json(['id' => $file->id,'name'=>$url]);
    }

    public function destroy($id)
    {
        $file=File::find($id);
        $file->delete();
    }

    public function getFiles(Request $request)
    {
        $model_object=app($this->getClass($request))::find($request->id);
        $files=$model_object->file;
        return response()->json($files);
    }
}
