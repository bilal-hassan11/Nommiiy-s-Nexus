<?php

namespace App\Repositories\Profile;

use App\Models\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

class ProfileRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }



    public function update($id, array $data)
{
    $user = $this->find($id);

    // Store the old file name to delete it later if it exists
    $oldFileName = $user->file_name;

    // Update user data
    $user->update($data);

    // Check if there's an image to store
    if (isset($data['file_name'])) {
        // Delete the old image if it exists
        if ($oldFileName) {
            $this->deleteImage($oldFileName);
        }

        // Store the new image
        $this->storeImage($user, $data['file_name']); // Call storeImage
    }

    return $user;
}




    public function storeImage(User $item, $base64Image)
    {
        $fileName = $this->getFileNameFromBase64($base64Image, 'filename');
        if ($fileName) {
            // Extract the image data
            $imageData = explode(',', $base64Image)[1];
            $imageData = base64_decode($imageData);

            // Store the image in the 'items' folder
            Storage::disk('public')->put('profile/' . $fileName, $imageData);
            $item->update(['file_name' => $fileName]);
        }
    }



    private function getFileNameFromBase64($base64String, $outputType = 'extension')
    {
        // Define a default filename or extension
        $defaultFilename = 'file';
        $defaultExtension = 'png';

        // Check if the base64 string contains a data URI scheme with MIME type
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $extension = $matches[1]; // Get the image extension
        } else {
            $extension = $defaultExtension; // Use default if MIME type not found
        }


        // Determine the output type
        if ($outputType === 'extension') {
            // Generate a filename with the extension
            $filename = $defaultFilename;
        } elseif ($outputType === 'filename') {
            $filename = uniqid() . '.' . $extension;
            // Generate a filename without any extension
        } else {
            // If outputType is not recognized, return null
            return null;
        }

        return $filename;
    }


    // Function to delete the old image
    public function deleteImage($fileName)
    {
        // Construct the path to the file
        $filePath = 'profile/' . $fileName;

        // Delete the file if it exists
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
