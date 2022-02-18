<?php

namespace App\Http\Services;

use Cloudinary\Api\Upload\UploadApi;

class ImageService
{
    private UploadApi $uploadApi;

    public function __construct(UploadApi $uploadApi)
    {
        $this->uploadApi = $uploadApi;
    }

    public function uploadImage($image, $folder){
        $response = $this->uploadApi->upload($image, ["folder" => "Instakilogram/".$folder]);
        return ['url' => $response['url'], 'cloud_id' => $response['public_id']];
    }

    public function deleteImage($cloudId){
        $this->uploadApi->destroy($cloudId);
    }

}
