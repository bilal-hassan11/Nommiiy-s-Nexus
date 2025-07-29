<?php

namespace App\Http\Controllers;

use App\Models\BlogContent;
use App\Models\BlogType; // Make sure to import BlogType
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogContentController extends Controller
{
    /**
     * Store a newly created blog content in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data using rules defined in a helper method
        $validatedData = $request->validate($this->rules());

        $localizedContent = [];
        $locales = ['en-bd', 'bn-bd', 'en-np', 'ne-np']; // Match your frontend locales

        foreach ($locales as $locale) {
            $localeData = $request->input("localized_content.{$locale}");
            $mobileImageFile = $request->file("localized_content.{$locale}.mobile_image");
            $webImageFile = $request->file("localized_content.{$locale}.web_image");

            $mobileImagePath = null;
            $webImagePath = null;

            if ($mobileImageFile) {
                // Store image and get its public URL
                $mobileImagePath = $mobileImageFile->store('blog_images', 'public');
                $mobileImagePath = Storage::url($mobileImagePath);
            }
            if ($webImageFile) {
                // Store image and get its public URL
                $webImagePath = $webImageFile->store('blog_images', 'public');
                $webImagePath = Storage::url($webImagePath);
            }

            $localizedContent[$locale] = [
                'title' => $localeData['title'] ?? null,
                'description' => $localeData['description'] ?? null,
                'content' => $localeData['content'] ?? null,
                'mobile_image_url' => $mobileImagePath, // Store the public URL
                'web_image_url' => $webImagePath, // Store the public URL
            ];
        }

        // Handle URL Title slug generation if not provided
        $urlTitle = $request->input('url_title');
        if (empty($urlTitle)) {
            $enBdTitle = $localizedContent['en-bd']['title'] ?? null;
            if ($enBdTitle) {
                $urlTitle = Str::slug($enBdTitle);
            } else {
                $urlTitle = Str::uuid(); // Fallback to a UUID
            }
        } else {
            $urlTitle = Str::slug($urlTitle);
        }

        // Ensure url_title is unique, append a suffix if necessary
        $originalUrlTitle = $urlTitle;
        $counter = 1;
        while (BlogContent::where('url_title', $urlTitle)->exists()) {
            $urlTitle = $originalUrlTitle . '-' . $counter++;
        }

        $blogContent = BlogContent::create([
            'blog_type_id' => $validatedData['blog_type_id'],
            'content_type' => $validatedData['content_type'],
            'status' => $validatedData['status'],
            'publish_date' => $validatedData['publish_date'],
            'author' => $validatedData['author'],
            'index' => $validatedData['index'],
            'url_title' => $urlTitle,
            'popular' => $validatedData['popular'],
            'localized_content' => $localizedContent,
        ]);

        return response()->json($blogContent, 201);
    }

    /**
     * Display the specified blog content. (Needed for future edit functionality)
     */
    public function show(string $id)
    {
        $blogContent = BlogContent::find($id);

        if (!$blogContent) {
            return response()->json(['message' => 'Blog content not found'], 404);
        }

        return response()->json($blogContent);
    }

    /**
     * Update the specified blog content in storage. (Placeholder, not fully implemented in frontend yet)
     */
    public function update(Request $request, string $id)
    {
        $blogContent = BlogContent::findOrFail($id);

        // Validate the request data using rules, passing the ID for unique checks
        $validatedData = $request->validate($this->rules($blogContent->id));

        $oldLocalizedContent = $blogContent->localized_content; // Get existing localized content

        $localizedContent = [];
        $locales = ['en-bd', 'bn-bd', 'en-np', 'ne-np']; // Match your frontend locales

        foreach ($locales as $locale) {
            $localeData = $request->input("localized_content.{$locale}");
            $mobileImageFile = $request->file("localized_content.{$locale}.mobile_image");
            $webImageFile = $request->file("localized_content.{$locale}.web_image");

            // Start with existing image URLs
            $mobileImagePath = $oldLocalizedContent[$locale]['mobile_image_url'] ?? null;
            $webImagePath = $oldLocalizedContent[$locale]['web_image_url'] ?? null;

            // Handle mobile image
            if ($mobileImageFile) {
                // Delete old image if a new one is uploaded
                if ($mobileImagePath) {
                    Storage::disk('public')->delete(Str::after($mobileImagePath, '/storage/'));
                }
                $mobileImagePath = $mobileImageFile->store('blog_images', 'public');
                $mobileImagePath = Storage::url($mobileImagePath);
            }
            // If no new mobileImageFile, the $mobileImagePath retains its old value or null

            // Handle web image
            if ($webImageFile) {
                // Delete old image if a new one is uploaded
                if ($webImagePath) {
                    Storage::disk('public')->delete(Str::after($webImagePath, '/storage/'));
                }
                $webImagePath = $webImageFile->store('blog_images', 'public');
                $webImagePath = Storage::url($webImagePath);
            }
            // If no new webImageFile, the $webImagePath retains its old value or null

            $localizedContent[$locale] = [
                'title' => $localeData['title'] ?? null,
                'description' => $localeData['description'] ?? null,
                'content' => $localeData['content'] ?? null,
                'mobile_image_url' => $mobileImagePath,
                'web_image_url' => $webImagePath,
            ];
        }

        // Handle URL Title slug generation if not provided or changed
        $urlTitle = $request->input('url_title');
        if (empty($urlTitle)) {
             $enBdTitle = $localizedContent['en-bd']['title'] ?? null;
             if ($enBdTitle) {
                 $urlTitle = Str::slug($enBdTitle);
             } else {
                 $urlTitle = Str::uuid(); // Fallback to a UUID
             }
        } else {
            $urlTitle = Str::slug($urlTitle);
        }

        // Ensure url_title is unique for other records
        $originalUrlTitle = $urlTitle;
        $counter = 1;
        while (BlogContent::where('url_title', $urlTitle)->where('id', '!=', $blogContent->id)->exists()) {
            $urlTitle = $originalUrlTitle . '-' . $counter++;
        }

        $blogContent->update([
            'blog_type_id' => $validatedData['blog_type_id'],
            'content_type' => $validatedData['content_type'],
            'status' => $validatedData['status'],
            'publish_date' => $validatedData['publish_date'],
            'author' => $validatedData['author'],
            'index' => $validatedData['index'],
            'url_title' => $urlTitle,
            'popular' => $validatedData['popular'],
            'localized_content' => $localizedContent,
        ]);

        return response()->json($blogContent);
    }

    /**
     * Common validation rules.
     */
    protected function rules($id = null)
    {
        $locales = ['en-bd', 'bn-bd', 'en-np', 'ne-np'];
        $rules = [
            'blog_type_id' => 'required|exists:blog_types,id',
            'content_type' => ['required', Rule::in(['Home', 'Slot', 'Card', 'Fish', 'Instant Win', 'Bango', 'Login', 'Signup'])],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'publish_date' => 'nullable|date',
            'author' => 'nullable|string|max:255',
            'index' => 'nullable|numeric', // Changed to numeric
            'url_title' => [
                'nullable',
                'string',
                'max:255',
                // Ensure unique across all records except the current one if updating
                Rule::unique('blog_contents')->ignore($id),
            ],
            'popular' => 'boolean',
        ];

        foreach ($locales as $locale) {
            $rules["localized_content.{$locale}.title"] = 'nullable|string|max:255';
            $rules["localized_content.{$locale}.description"] = 'nullable|string|max:300';
            $rules["localized_content.{$locale}.content"] = 'nullable|string';
            // Validation rules for image files
            $rules["localized_content.{$locale}.mobile_image"] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'; // 2MB max
            $rules["localized_content.{$locale}.web_image"] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'; // 2MB max
        }

        return $rules;
    }

    /**
     * Remove the specified blog content from storage. (Optional)
     */
    public function destroy(string $id)
    {
        $blogContent = BlogContent::findOrFail($id);

        // Delete associated images from storage
        $locales = ['en-bd', 'bn-bd', 'en-np', 'ne-np'];
        foreach ($locales as $locale) {
            if (isset($blogContent->localized_content[$locale]['mobile_image_url']) && $blogContent->localized_content[$locale]['mobile_image_url']) {
                // Extract path from URL and delete
                Storage::disk('public')->delete(Str::after($blogContent->localized_content[$locale]['mobile_image_url'], '/storage/'));
            }
            if (isset($blogContent->localized_content[$locale]['web_image_url']) && $blogContent->localized_content[$locale]['web_image_url']) {
                Storage::disk('public')->delete(Str::after($blogContent->localized_content[$locale]['web_image_url'], '/storage/'));
            }
        }

        $blogContent->delete();

        return response()->json(null, 204);
    }

    /**
     * Optional: Index method to list all blog content (for displaying in a table, etc.)
     */
    public function index()
    {
        $blogContents = BlogContent::with('blogType')->latest()->get();
        return response()->json($blogContents);
    }
}