<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use App\Repositories\ImageRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    protected $imageRepository;
    protected $file;

    public function __construct(ImageRepository $imageRepository, File $file)
    {
        $this->imageRepository = $imageRepository;
        $this->file = $file;
    }

    /**
     * Handle upload image
     * @param \App\Http\Requests\ImageUploadRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function upload(ImageUploadRequest $request)
    {
        // Get file from request
        $files = $request->img;
        Log::channel('custom_log')->info('ImageController:upload', ['files' => $files]);
        Log::channel('custom_log')->info('ImageController:upload' . print_r($files, true));
        $image = null;

        if (isset($files)) {
            foreach ($files as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store('images', 'public');
                    // Save image data to database
                    $imageData = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'driver_test_id' => $request->driver_test_id,
                    ];

                    $image = $this->imageRepository->create($imageData);
                }
            }
        }
        // Store file to storage
        return response()->json(['images' => $image], 201);
    }


    /**
     * Handle remove old image update new image
     * @param \App\Http\Requests\ImageUploadRequest $request
     * @return void
     */
    public function update(ImageUploadRequest $request)
    {
        $driver_test_id = $request->driver_test_id;

        $files = $request->img;

        if (isset($files) && $files[0] instanceof \Illuminate\Http\UploadedFile) {
            // Find images by driver_test_id
            $images = $this->imageRepository->findByTestDriverId($driver_test_id);

            // Delete old images
            foreach ($images as $image) {
                $this->imageRepository->delete($image->id);
                // Delete image file
                File::delete(storage_path('app/public/' . $image->path));
            }
            $this->upload($request);
        }
    }
}
