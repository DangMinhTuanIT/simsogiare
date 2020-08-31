<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;

use Intervention\Image\Font;

use Illuminate\Support\Facades\File;



class ImageController extends Controller

{

    public function get_image($phonesim,$price_int,$type,$theloaisim){

        $directory =  base_path('/public/images/vietnammobile.png');
        switch ($theloaisim) {
            case 1:
               $directory =  base_path('/public/images/viettel.png');
                break;
             case 2:
               $directory =  base_path('/public/images/mobifone.png');
                break;
            case 3:
               $directory =  base_path('/public/images/vinaphone.png');
                break;
            case 4:
               $directory =  base_path('/public/images/vietnammobile.png');
                break;
            case 5:
               $directory =  base_path('/public/images/gmobile.png');
                break;  
            default:
                # code...
                break;
        }
        $img = Image::make($directory);

        // write text
        // write text at position
        $phone_sim = $phonesim;
        $img->text($phonesim, 200, 110, function($font) {
            $font->file(base_path('public/css/fonts/Montserrat-Bold.ttf'));
            $font->size(18);
            $font->angle(0);
              $font->color('#000');
        });
        $price_str = \App\myHelper::convert_money($price_int);
        $price = 'Giá: '.$price_str.'đ';
        $img->text($price, 200, 130, function($font) {
            $font->file(base_path('public/css/fonts/Montserrat-Bold.ttf'));
            $font->size(12);
            $font->angle(0);
              $font->color('#000');
        });
        $type_sim = 'Loại sim: '.$type;
        $img->text($type_sim, 200, 150, function($font) {
            $font->file(base_path('public/css/fonts/Montserrat-Bold.ttf'));
            $font->size(12);
            $font->angle(0);
              $font->color('#000');
        });
        $generate = '/uploads/images/generate/'.$phone_sim.'.png';
        $img->save(base_path('/uploads/images/generate/'.$phone_sim.'.png'));
        return $generate;
    }
    public function getImageThumbnail($images_path,$path, $width = null, $height = null, $type = "fit")

    {

        //$images_path = config('app.images_path');

        $path = ltrim($path, "/");

        //returns the original image if isn't passed width and height

        if (is_null($width) && is_null($height)) {

            return url("{$images_path}/" . $path);

        }

        //if thumbnail exist returns it

        if (File::exists(base_path("{$images_path}/thumbs/" . "{$width}x{$height}/" . $path))) {

            return url("{$images_path}/thumbs/" . "{$width}x{$height}/" . $path);

        }

        //If original image doesn't exists returns a default image which shows that original image doesn't exist.

        if (!File::exists(base_path("{$images_path}/" . $path))) {

            /*

             * 2 ways

             */

            //1. recursive call for the default image

            //return $this->getImageThumbnail("error/no-image.png", $width, $height, $type);

            //2. returns an image placeholder generated from placehold.it

            //return "http://placehold.it/{$width}x{$height}";

			return "https://dummyimage.com/{$width}x{$height}/000/fff";

        }

        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

        $contentType = @mime_content_type("{$images_path}/" . $path);

        if (in_array($contentType, $allowedMimeTypes)) { //Checks if is an image

            $image = Image::make(base_path("{$images_path}/" . $path));

            switch ($type) {

                case "fit": {

                    $image->fit($width, $height, function ($constraint) {

                        $constraint->upsize();

                    });

                    break;

                }

                case "resize": {

                    //stretched

                    $image->resize($width, $height, function ($constraint) {

                        $constraint->aspectRatio();

                        //$constraint->upsize();

                    });

                    $image->resizeCanvas($width, $height, 'center', false, 'rgba(255, 255, 255, 0)');

                    break;

                }

                case "background": {

                    $image->resize($width, $height, function ($constraint) {

                        //keeps aspect ratio and sets black background

                        $constraint->aspectRatio();

                        $constraint->upsize();

                    });

                    break;

                }

                case "resizeCanvas": {

                    $image->resizeCanvas($width, $height, 'center', false, 'rgba(255, 255, 255, 0)'); //gets the center part

                    break;

                }

                case "width":{

                    $image->resize($width, null, function ($constraint) {

                        $constraint->aspectRatio();

                        $constraint->upsize();

                    });

                    break;

                }

                case "height":{

                    $image->resize(null, $height, function ($constraint) {

                        $constraint->aspectRatio();

                        $constraint->upsize();

                    });

                    break;

                }

                default:{

                    $image->resize($width, $height, function ($constraint) {

                        $constraint->aspectRatio();

                        $constraint->upsize();

                    });

                }





            }

            //relative directory path starting from main directory of images

            $dir_path = (dirname($path) == '.') ? "" : dirname($path);

            //Create the directory if it doesn't exist

            if (!File::exists(base_path("{$images_path}/thumbs/" . "{$width}x{$height}/" . $dir_path))) {

                File::makeDirectory(base_path("{$images_path}/thumbs/" . "{$width}x{$height}/" . $dir_path), 0775, true);

            }

            //Save the thumbnail

            $image->save(base_path("{$images_path}/thumbs/" . "{$width}x{$height}/" . $path));

            //return the url of the thumbnail

            return url("{$images_path}/thumbs/" . "{$width}x{$height}/" . $path);

        } else {

            //return a placeholder image

            //return "http://placehold.it/{$width}x{$height}";

			return "https://dummyimage.com/{$width}x{$height}/000/fff";

        }

    }

}

