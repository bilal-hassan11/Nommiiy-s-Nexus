<?php

namespace App\Repositories\User;

use App\Models\Role;
use App\Models\User;
use App\Enums\UserStatus;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class UserRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    function get_system_user_id()
    {
        $user_id = auth()->user()->id;
        $systemUser = User::where('id', $user_id)->first();

        if ($systemUser->type == 'user') {
            return $systemUser->system_user_id;
        } else {
            return $systemUser->id;
        }
    }
    function get_login_user_id()
    {
        $user_id = auth()->user()->id;
        if ($user_id) {
            return $user_id;
        } else {
            return false;
        }
    }

    public function createUser(array $data)
    {

        $role = Role::find($data['role_id']);

        if (!$role) {
            throw new \Exception("Role not found.");
        }

        // Set default status to 'active' if not provided
        $data['status'] = $data['status'] ?? UserStatus::ACTIVE->value;
        $data['type'] = 'user';

        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        // Set system_user_id and user_id
        $data['system_user_id'] = get_login_user_id();
        $data['user_id'] = get_login_user_id();

        // Create the user
        $user = $this->model->create($data);

        // Check if there's an image to store
        if (isset($data['image'])) {
            $this->storeImage($user, $data['image']);
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
            $item->update(['image' => $fileName]);
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



    // Update user method
    public function updateUser(int $id, array $data)
    {
        // Find the user by ID
        $user = $this->model->findOrFail($id);
        $oldFileName = $user->image;
        // Update the user details
        $user->update($data);
        // Check if there's an image to store
        if (isset($data['image'])) {
            // Delete the old image if it exists
            if ($oldFileName) {
                $this->deleteImage($oldFileName);
            }

            // Store the new image
            $this->storeImage($user, $data['image']); // Call storeImage
        }
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



    public function getUserFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Dynamically instantiate the model class
        $query = app($modelClass)->newQuery();

        // Apply selected columns
        $query->select($columns);
        $query->where('type','user');

        // Eager load the role and specify the fields
        if (!empty($with)) {
            $query->with([
                'role:id,name', // Only select id and name from the roles and building
            ]);
        }

        // Apply search term if provided
        if (!empty($conditions['searchTerm'])) {
            $query->where(function ($q) use ($conditions) {
                // Check for active or inactive status
                if (strtolower($conditions['searchTerm']) === 'active') {
                    $q->where('status', 'active');
                } elseif (strtolower($conditions['searchTerm']) === 'inactive') {
                    $q->where('status', 'inactive');
                } else {
                    // Filter by name, email, or other fields
                    $q->where('name', 'like', "%{$conditions['searchTerm']}%")
                        ->orWhere('email', 'like', "%{$conditions['searchTerm']}%")
                        ->orWhere('phone', 'like', "%{$conditions['searchTerm']}%")
                        ->orWhereHas('role', function ($q) use ($conditions) {
                            $q->where('name', 'like', "%{$conditions['searchTerm']}%");
                        });
                }
            });
        }


        // Apply sorting if the column exists
        if (Schema::hasColumn(app($modelClass)->getTable(), $sortBy)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate the results
        return $query->paginate($perPage, $columns);
    }


    public function getById($id, array $with = [], array $columns = ['*'])
    {
        // Default relationships to eager load if none specified
        $defaultRelations = ['role:id,name']; // Only select 'id' and 'name' from 'role and building'

        // Merge default relations with any additional ones provided
        $with = array_merge($defaultRelations, $with);

        return parent::find($id, $with, $columns);
    }



    public function deleteUser(int $id)
    {
        $package = $this->model->findOrFail($id);
        $package->delete();
    }

    public function deleteUsers(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
