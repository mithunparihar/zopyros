<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AvifEncoder;
use Intervention\Image\ImageManager;

class Image
{
    // Show Image URL
    function showFile($pathName, $width, $imageName, $folder = null)
    {

        $pathNameArr = explode('_', $pathName);
        $pathName    = implode('/', $pathNameArr);

        if (! empty($imageName) && file_exists(public_path('storage/' . $pathName . '/' . ($folder ?? 'original') . '/' . $imageName))) {
            return route('image.resize', [
                'filename' => $imageName,
                'path'     => str_replace('/', '_', $pathName),
                'folder'   => $folder ?? 'original',
                'width'    => $width,
            ]);
        } elseif (! empty($imageName) && file_exists(public_path('storage/' . $pathName . '/' . $imageName))) {
            return asset('storage/' . $pathName . '/' . $imageName);
        } else {
            return asset('admin/img/no-img.webp');
        }

    }

    // Remove Image
    function removeFile($path, $image)
    {
        $path = 'storage/' . $path;
        $this->deleteImageVariants($image, $path);
    }

    function deleteImageVariants($filename, $directory)
    {
        $baseFilename = basename($filename);
        $path         = public_path($directory);

        if (file_exists($path . 'original/' . $filename)) {
            $allFiles = File::files($path . 'original');
            foreach ($allFiles as $file) {
                $currentName = $file->getFilename();
                if ($currentName === $baseFilename || str_ends_with($currentName, "_$baseFilename")) {
                    File::delete($file->getPathname());
                }
            }
        }

        if (file_exists($path . 'webp/' . $filename)) {
            $allFiles2 = File::files($path . 'webp');
            /// WEBP IMAGE REMOVE
            $Arr = explode('.', $baseFilename);
            array_pop($Arr);
            $baseFilename = implode('', $Arr) . '.webp';
            foreach ($allFiles2 as $file) {
                $currentName = $file->getFilename();
                if ($currentName === $baseFilename || str_ends_with($currentName, "_$baseFilename")) {
                    File::delete($file->getPathname());
                }
            }
        }
    }

    // Make Directory
    public static function makeDirctory($path)
    {
        $path = public_path($path);
        if (! File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    public static function uploadFile($path, $image, $withOriginalName = false)
    {
        $path = $path;
        self::makeDirctory($path);
        $filenameWithExt = $image->getClientOriginalName();
        $extention       = $image->getClientOriginalExtension();
        if (! $withOriginalName) {
            $projectname     = str_replace(' ', '-', \Content::ProjectName());
            $filenameWithExt = strtolower($projectname . '-');
            $filenameWithExt = uniqid($filenameWithExt) . '.' . $extention;
        }
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $path     = $image->storeAs($path, $filenameWithExt, 'public');
        return $filenameWithExt;

    }

    public static function directFile($path, $image, $options = [])
    {
        self::makeDirctory($path);
        $name      = $image->getClientOriginalName();
        $extention = $image->getClientOriginalExtension();
        if (! empty($options['originalName'])) {
            $fileName = strtolower(str_replace(' ', '-', $name));
        } else {
            $projectname = str_replace(' ', '-', \Content::ProjectName());
            $fileName    = strtolower($projectname . '-');
            $fileName    = uniqid($fileName) . '.' . $extention;
        }
        $imgmanager = new ImageManager(new Driver());
        $newImage   = $imgmanager->read($image);
        if (($options['watermark'] ?? false) == true) {
            $newImage->place(public_path('admin/img/logo.png'));
        }
        $newImage->save(public_path($path . $fileName));
        return $fileName;
    }

    public static function autoheight($path, $image, $options = [])
    {
        $path         = 'storage/' . $path;
        $originalPath = $path ;

        self::makeDirctory($originalPath);

        $extention = $image->getClientOriginalExtension();

        $fileName = self::directFile($originalPath, $image, $options);
        // if (strtoupper($extention) != 'WEBP') {
        //     self::converttowebp($path, $image, $fileName, $options);
        // }

        return $fileName;
    }
    public static function converttowebp($path, $image, $fileName, $options)
    {
        self::makeDirctory($path . 'webp');

        $imgmanager = new ImageManager(new Driver());
        $newImage   = $imgmanager->read($image);
        // $newImage->scale($width);

        if ($options['watermark'] ?? false == true) {
            $newImage->place(public_path('admin/img/logo.png'));
        }

        $Arr = explode('.', $fileName);
        array_pop($Arr);
        $newImage->toWebp(60)->save(public_path($path . 'webp/' . implode('', $Arr) . '.webp'));
    }

    function getBinary($path, $width,$filename,$folder=null)
    {
        $Arr  = explode('_', $path);
        $path = implode('/', $Arr);

        $storagePath = $folder
        ? "storage/{$path}/{$folder}/ws_{$width}_{$filename}"
        : "storage/{$path}/ws_{$width}_{$filename}";

        $resizedPath = public_path($storagePath);

        if (file_exists($resizedPath)) {
            return file_get_contents($resizedPath);
        }

        $storagePath = $folder
        ? "storage/{$path}/{$folder}/{$filename}"
        : "storage/{$path}/{$filename}";

        $originalFullPath = public_path($storagePath);

        if (! file_exists($originalFullPath)) {abort(404);}

        $binary = \Image::convertSize($width, $originalFullPath);

        file_put_contents($resizedPath, $binary);

        return $binary;
    }

    function convertSize($width, $path)
    {
        $imgManager = new ImageManager(new Driver());
        $image      = $imgManager->read($path);

        $imgWidth = $image->width();
        $height   = $image->height();

        if ($imgWidth < $width || $width <= 0) {
            $width = $imgWidth;
        }

        $image = $image->scale($width, null);

        return (string) $image->encode(new AvifEncoder());
    }
}
