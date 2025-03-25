<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;


function menuActive($data)
{
    if (!is_array($data)) {
        $data = explode(', ', $data);
    }
    foreach ($data as $value) {
        if (request()->routeIs($value)) {
            return true;
        }
    }
    return false;
}
if (!function_exists('imageRecover')) {

    function imageRecover($path)
    {
        if ($path == null || !Storage::disk('public')->exists($path)) {
            return asset('assets/backend/dist/img/default-150x150.png');
        }

        $storage_link = Storage::url($path);
        if (readConfig('core_folder') == 1) {
            $storage_link = 'core/public' . $storage_link;
        }

        return asset($storage_link);
    }
}

if (!function_exists('imageRecoverNull')) {

    function imageRecoverNull($path)
    {
        if ($path == null || !Storage::disk('public')->exists($path)) {
            return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
        }

        $storage_link = Storage::url($path);
        if (readConfig('core_folder') == 1) {
            $storage_link = 'core/public' . $storage_link;
        }

        return asset($storage_link);
    }
}


if (!function_exists('docRecover')) {

    function docRecover($path)
    {
        if ($path == null || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $storage_link = Storage::url($path);
        if (readConfig('core_folder') == 1) {
            $storage_link = 'core/public' . $storage_link;
        }

        return asset($storage_link);
    }
}


if (!function_exists('writeConfig')) {
    function writeConfig($key, $value)
    {
        config(['system.' . $key => $value]);
        $fp = fopen(base_path() . '/config/system.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config('system'), true) . ';');
        fclose($fp);

        return @$value;
    }
}

if (!function_exists('readConfig')) {
    function readConfig($key)
    {
        return @config('system.' . $key);
    }
}

if (!function_exists('assetImage')) {

    function assetImage($path)
    {
        if ($path == null || !file_exists(public_path($path))) {
            return asset('assets/images/nofav.png');
        }

        return asset($path);
    }
}

if (!function_exists('slugify')) {

    function slugify($text)
    {
        return Str::slug($text);
    }
}

if (!function_exists('snakeToTitle')) {

    function snakeToTitle($text)
    {
        return Str::title(Str::snake(Str::studly($text), ' '));
    }
}

if (!function_exists('nullImg')) {

    function nullImg()
    {
        return "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
    }
}


function uploader($file, $path, $width = null, $height = null)
{
    $path = ltrim($path, '/');
    $originalName = $file->getClientOriginalName();
    $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
    $file_name = time() . "-" . Str::slug($filenameWithoutExtension).'.'.$file->getClientOriginalExtension();
    $storingPath = storage_path() . "/app/public/" . $path . "/" . $file_name;
    if (!Storage::exists('public/' . $path)) {
        Storage::makeDirectory('public/' . $path);
    }

    $img = Image::make($file->getRealPath());
    if ($width != null || $height != null) {
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    $img->save($storingPath);

    // Remove Public from link
    return $path . "/" . $file_name;
}

function uploadToPublic($file, $path = "/assets/images")
{
    $originalName = $file->getClientOriginalName();
    $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
    $file_name = time() . "-" . Str::slug($filenameWithoutExtension).'.'.$file->getClientOriginalExtension();
    $storingPath = public_path() . $path . "/" . $file_name;

    // if (!file_exists($path)) {
    //     mkdir($path, 0777, true);
    // }

    Image::make($file->getRealPath())->resize(null, 400, function ($constraint) {
        $constraint->aspectRatio();
    })->save($storingPath);

    return $path . "/" . $file_name;
}

function securePublicUnlink($path)
{
    $absolute_path = public_path($path);

    if (file_exists($absolute_path) && is_file($absolute_path)) {
        unlink($absolute_path);
        return true;
    } else {
        return false;
    }
}

function uploadImage($file, $path = "/public/media/others")
{
    return uploader($file, $path, null, null);
}
function uploadImageAndGetPath($file, $path = "/public/media/others")
{
    return uploader($file, $path, null, 400);
}

function uploadBigImageAndGetPath($file, $path = "/public/media/others")
{
    return uploader($file, $path, 800, null);
}

function uploadIconImageAndGetPath($file, $path = "/public/media/others")
{
    return uploader($file, $path, null, 200);
}

function secureUnlink($path)
{
    $absolute_path = storage_path() . '/app/public/' . $path;

    if (file_exists($absolute_path) && is_file($absolute_path)) {
        unlink($absolute_path);
        return true;
    } else {
        return false;
    }
}

function fileUploadAndGetPath($file, $path = "/public/media/others")
{
    $file_name = time() . "_" . $file->getClientOriginalName();

    $file->storeAs($path, $file_name);

    // Remove Public from link
    return substr($path . "/" . $file_name, 8);
}

function en2bn($number) {
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $months = [
        'January' => 'জানুয়ারী',
        'February' => 'ফেব্রুয়ারী',
        'March' => 'মার্চ',
        'April' => 'এপ্রিল',
        'May' => 'মে',
        'June' => 'জুন',
        'July' => 'জুলাই',
        'August' => 'আগস্ট',
        'September' => 'সেপ্টেম্বর',
        'October' => 'অক্টোবর',
        'November' => 'নভেম্বর',
        'December' => 'ডিসেম্বর'
    ];
    foreach ($months as $enMonth => $bnMonth) {
        $number = str_replace($enMonth, $bnMonth, $number);
    }
    return str_replace($en, $bn, $number);
}

