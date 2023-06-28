<?php

namespace App\Http\Controllers;

use App\Library\Imagetool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FilemanagerController extends Controller
{
    public function getFolderDirectory(Request $request)
    {
        $directory = 'catalog/';
    	if (isset($request->directory)) {
    	    if (str_contains($request->directory,'catalog'))
            {
                $directory = rtrim($request->directory);

            }
        }
        $files = Storage::files($directory);
        $directories = Storage::directories($directory);
    	if (!$directories) {
            $directories = array();
        }
        if (!$files) {
            $files = array();
        }
        $datas = [];
        $datas['directory'] = $directory;
        $datas['file_count'] = count($files);
        foreach($files as $k=>$file)
        {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
        	$name = basename($file);
        	$datas['files'][$k] = [
        		'name' => $name,
                'path_name' => $file,
        		'image' => Imagetool::mycrop($file,100,100),
        		'extension' => $extension
        	];
        }
        $datas['folder_count'] = count($directories);
        foreach($directories as $k=>$dir)
        {
        	$datas['folders'][$k] = [
        		'name' => basename($dir),
        		'full_path' => $dir
        	];
        }
        return response()->json([
            'data' => $datas,
            'message' => 'directory detail datas'
        ]);
    }
    public function storeFile(Request $request)
    {
        $this->validate($request, [
            'files.*' => 'required|mimes:jpg,png,jpeg,webp,svg,gif'
        ]);
        $files = $request->file('files');
        $path = Str::remove('image/', $request->directory);
        foreach($files as $file)
        {
            $file_name = Str::replace(" ", "-", $file->getClientOriginalName());
            Storage::putFileAs(
                $path, $file, $file_name
            );
        }
        return response()->json([
            'message' => 'Files Uploaded to desired Path!'
        ]);
    }
    public function storeFolder(Request $request)
    {
        $this->validate($request, [
            'folder_name' => 'required|string',
            'directory' => 'sometimes|string'
        ]);
    	if (isset($request->directory) && !empty($request->directory)) {
            $directory = $request->directory;
        } else {
            $directory = 'catalog';
        }
        if (!Storage::exists($directory)) {
            return 'Not Found!';
        }

        $folder = $request->folder_name;
        $folder = str_replace(' ', '_', $folder);

        if (Storage::exists($directory . '/' . $folder)) {
            return 'This Directory is already Exist';
        }

        Storage::makeDirectory($directory . '/' . $folder);
        return response()->json([
            'folder' => $folder,
            'message' => 'Folder Created Successfully!'
        ]);
    }
    public function deleteFile(Request $request)
    {
        $path = $request->file_path;
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json([
                'path' => $path,
                'message' => 'File/Directory deleted Successfully!'
            ]);
        } else{
            return response()->json([
                'message' => 'File Not Found!'
            ]);
        }
    }
    public function deleteFolder(Request $request)
    {
        if ($request->directory_path != 'catalog/')
        {
            return $request->directory_path;
            if (Storage::exists($request->directory_path)) {
                Storage::deleteDirectory($request->directory_path);
                return response()->json([
                    'directory' => $request->directory_path,
                    'message' => 'File/Directory deleted Successfully!'
                ]);
            }else{
                return response()->json([
                    'message' => 'Directory Not Found!'
                ]);
            }
        }
        return response()->json([
            'message' => 'You can not delete this directory'
        ]);
    }
    public function getStorageFolderDirectory(Request $request)
    {


        $directory = 'catalog/';
        if (isset($request->directory)) {
            if (str_contains($request->directory,'catalog'))
            {
                $directory = rtrim(Str::remove('image/', $request->directory));
            }
        }

        $files = Storage::files($directory);


        $directories = Storage::directories($directory);
        if (!$directories) {
            $directories = array();
        }

        if (!$files) {
            $files = array();
        }

        $datas = [];
        $datas['directory'] = $directory;
        $datas['file_count'] = count($files);
        foreach($files as $k=>$file)
        {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $size = Storage::size($file);
            $name = basename($file);
            $datas['files'][$k] = [
                'name' => $name,
                'path_name' => $directory.$name,
                'image' => Imagetool::mycrop($directory.$name,100,100),
                'extension' => $extension,
                'size' => $size
            ];
        }
        $datas['folder_count'] = count($directories);
        foreach($directories as $k=>$dir)
        {
            $datas['folders'][$k] = [
                'name' => basename($dir),
                'full_path' => $dir
            ];
        }

        return $datas;
    }
}
