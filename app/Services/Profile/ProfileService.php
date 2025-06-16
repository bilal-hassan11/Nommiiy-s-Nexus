<?php

namespace App\Services\Profile;

use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Profile\ProfileRepository;

class ProfileService extends BaseService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        // Pass the repository to the BaseService
        parent::__construct($profileRepository);
        $this->profileRepository = $profileRepository;
    }


    public function updateProfile(int $userId, array $data): bool
    {
        $authenticatedUser = Auth::user();

        // Check if the authenticated user ID matches the requested user ID
        if ($authenticatedUser->id != $userId) {
            return false;
        }

        // Update the profile and return true if successful
        return $this->profileRepository->update($userId, $data) ? true : false;
    }

    
    
}
