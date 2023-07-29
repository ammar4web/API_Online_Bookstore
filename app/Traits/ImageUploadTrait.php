<?php

namespace App\Traits;

trait ImageUploadTrait
{
    protected static $image_path  = "app/public/images/covers";
    protected static $img_height = 600;
    protected static $img_width = 600;

    public static function uploadImage($img)
    {
        $img_name = self::imageName($img);

        \Image::make($img)->resize(self::$img_width, self::$img_height)->save(storage_path(self::$image_path.'/'.$img_name));

        return "images/covers/" . $img_name;
    }

    public static function imageName($image)
    {
        return time().'-'.$image->getClientOriginalName();
    }
}
