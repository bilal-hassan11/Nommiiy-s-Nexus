<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // For deleting old logos

class MemberGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'level',
        'logo_path',
        'status',
        'sequence',
        'remark',
    ];

    /**
     * Get the full URL for the group logo.
     *
     * @return string|null
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? Storage::url($this->logo_path) : null;
    }

    /**
     * The "booted" method of the model.
     *
     * Deletes the associated logo file when a group record is deleted.
     */
    protected static function booted(): void
    {
        static::deleting(function (Group $group) {
            if ($group->logo_path && Storage::disk('public')->exists($group->logo_path)) {
                Storage::disk('public')->delete($group->logo_path);
            }
        });
    }
}