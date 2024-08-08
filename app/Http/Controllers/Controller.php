<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function zeroCrop($filePath)
    {
        list($width, $height, $type) = getimagesize($filePath);

        if ($type !== IMAGETYPE_JPEG && $type !== IMAGETYPE_PNG) {
            echo 'Unsupported image type';
            exit;
        }

        $source = ($type === IMAGETYPE_JPEG) ? imagecreatefromjpeg($filePath) : imagecreatefrompng($filePath);
        $newWidth = $width - 0;
        $newHeight = $height - 0;
        $croppedImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($type === IMAGETYPE_PNG) {
            imagealphablending($croppedImage, false);
            imagesavealpha($croppedImage, true);
            $transparent = imagecolorallocatealpha($croppedImage, 0, 0, 0, 127);
            imagefill($croppedImage, 0, 0, $transparent);
            imagecopy($croppedImage, $source, 0, 0, 1, 1, $newWidth, $newHeight);
        } else {
            imagecopyresampled($croppedImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $newWidth, $newHeight);
        }

        if ($type === IMAGETYPE_JPEG) {
            imagejpeg($croppedImage, $filePath);
        } else {
            imagepng($croppedImage, $filePath);
        }

        imagedestroy($croppedImage);
        imagedestroy($source);
    }
}
