<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_type_id',
        'content_type',
        'status',
        'publish_date',
        'author',
        'index',
        'url_title',
        'popular',
        'localized_content',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'popular' => 'boolean',
        'localized_content' => 'array',
    ];

    // Define the relationship with BlogType
    public function blogType()
    {
        return $this->belongsTo(BlogType::class);
    }

    // Mutator to automatically generate url_title if not provided
    public function setUrlTitleAttribute($value)
    {
        if (empty($value) && !empty($this->attributes['localized_content'])) {
            // Attempt to use title from 'en-bd' locale for slug if URL title is empty
            $localizedContent = json_decode($this->attributes['localized_content'], true);
            if (isset($localizedContent['en-bd']['title']) && !empty($localizedContent['en-bd']['title'])) {
                $this->attributes['url_title'] = Str::slug($localizedContent['en-bd']['title']);
            } else {
                // Fallback or unique ID if no title available
                $this->attributes['url_title'] = Str::uuid(); // Use UUID as fallback if title is empty
            }
        } else {
            $this->attributes['url_title'] = Str::slug($value);
        }
    }
}