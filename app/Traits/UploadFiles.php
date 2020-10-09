<?php
namespace App\Traits;

use Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait UploadFiles
{

    /**
     * @method uploadFile
     * 
     * check if the initiative belongs to the logged in user's unit or committee
     * 
     * @param $file   => is the file sent in the form
     * @param $type   => is the file type in the system
     * @param $name   => the name of the module
     * @param $folder => the folder that the files will store at
     * 
     * @return @String 
     */
    public function uploadFile($file , $object, $objectFileType , $fileType , $folder,$hight=null,$width=null){

        $fileName = $fileType."_".$object."_".$objectFileType."_".time().'.'.$file->getClientOriginalExtension();


        if ($fileType == 'image') {

            $image_resize = Image::make($file->getRealPath());  
            
            if ($hight && $width) {
                $image_resize->resize($hight, $width);
            }            
            
            
            if (!file_exists(public_path('images/'.$folder))) {
                mkdir(public_path('images/'.$folder), 0755, true);
            }
            
            $path = public_path('images/'.$folder.'/'.$fileName);

            // $file->storeAs($folder,$fileName);
            $image_resize->save($path);
            
            return $fileName;
        }elseif ($fileType =='video') {
            
            if (!file_exists(public_path('videos/'.$folder))) {
                mkdir(public_path('videos/'.$folder), 777, true);
            }

            $path = public_path('videos/'.$folder.'/'.$fileName);

            // $filename = $file->getClientOriginalName();
            $path = public_path('videos/'.$folder);
            $file->move($path, $fileName);
            return $fileName;

        }elseif ($fileType =='file') {
            
            if (!file_exists(public_path('files/'.$folder))) {
                mkdir(public_path('files/'.$folder), 777, true);
            }

            $path = public_path('files/'.$folder.'/'.$fileName);

            // $filename = $file->getClientOriginalName();
            $path = public_path('files/'.$folder);
            $file->move($path, $fileName);
            return $fileName;

        }
        
    }
}
