<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * رفع صورة واحدة مع ضغطها وتحويلها إلى WebP
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string|null
     */
    public function uploadSingle(
        UploadedFile $file,
        string $directory,
        int $width = 800,
        int $height = 800,
        int $quality = 80
    ): ?string {
        try {
            // التأكد من أن المجلد موجود
            $this->ensureDirectoryExists($directory);

            // محاولة رفع الصورة بصيغة WebP أولاً
            try {
                $filename = $this->generateUniqueFilename('img', 'webp');
                $image = Image::make($file)
                    ->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', $quality);

                Storage::disk('public')->put($directory . $filename, $image);
                
                // 🔄 نسخ الصورة إلى public/storage للـ Windows
                $this->copyToPublicStorage($directory . $filename);
                
                return $directory . $filename;
            } catch (\Exception $e) {
                // في حالة فشل WebP، استخدم JPG
                \Log::warning('Failed to encode as WebP, falling back to JPG: ' . $e->getMessage());
                
                $filename = $this->generateUniqueFilename('img', 'jpg');
                $image = Image::make($file)
                    ->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', $quality);

                Storage::disk('public')->put($directory . $filename, $image);
                
                // 🔄 نسخ الصورة إلى public/storage للـ Windows
                $this->copyToPublicStorage($directory . $filename);
                
                return $directory . $filename;
            }
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * رفع عدة صور
     *
     * @param array $files
     * @param string $directory
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return array
     */
    public function uploadMultiple(
        array $files,
        string $directory,
        int $width = 800,
        int $height = 800,
        int $quality = 80
    ): array {
        $uploadedImages = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $path = $this->uploadSingle($file, $directory, $width, $height, $quality);
                if ($path) {
                    $uploadedImages[] = $path;
                }
            }
        }

        return $uploadedImages;
    }

    /**
     * حذف صورة
     *
     * @param string|null $imagePath
     * @return bool
     */
    public function delete(?string $imagePath): bool
    {
        if (empty($imagePath)) {
            return false;
        }

        try {
            if (Storage::disk('public')->exists($imagePath)) {
                return Storage::disk('public')->delete($imagePath);
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to delete image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف عدة صور
     *
     * @param array|null $imagePaths
     * @return int عدد الصور المحذوفة بنجاح
     */
    public function deleteMultiple(?array $imagePaths): int
    {
        if (empty($imagePaths) || !is_array($imagePaths)) {
            return 0;
        }

        $deletedCount = 0;
        foreach ($imagePaths as $path) {
            if ($this->delete($path)) {
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * حذف مجلد كامل وجميع محتوياته
     *
     * @param string $directory
     * @return bool
     */
    public function deleteDirectory(string $directory): bool
    {
        try {
            if (Storage::disk('public')->exists($directory)) {
                return Storage::disk('public')->deleteDirectory($directory);
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to delete directory: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * الحصول على URL الكامل للصورة
     *
     * @param string|null $imagePath
     * @return string|null
     */
    public function getImageUrl(?string $imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        return Storage::disk('public')->url($imagePath);
    }

    /**
     * توليد اسم ملف فريد
     *
     * @param string $prefix
     * @param string $extension
     * @return string
     */
    private function generateUniqueFilename(string $prefix, string $extension): string
    {
        return $prefix . '_' . uniqid('', true) . '_' . time() . '.' . $extension;
    }

    /**
     * التأكد من وجود المجلد وإنشائه إذا لم يكن موجوداً
     *
     * @param string $directory
     * @return void
     */
    private function ensureDirectoryExists(string $directory): void
    {
        $fullPath = storage_path('app/public/' . $directory);
        
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
    }

    /**
     * التحقق من صحة نوع الصورة
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function isValidImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $allowedMimes);
    }

    /**
     * الحصول على حجم الصورة بالميجابايت
     *
     * @param UploadedFile $file
     * @return float
     */
    public function getImageSizeMB(UploadedFile $file): float
    {
        return round($file->getSize() / 1024 / 1024, 2);
    }

    /**
     * رفع صورة منتج
     *
     * @param UploadedFile $file
     * @param string $productSlug
     * @param bool $isMain
     * @return string|null
     */
    public function uploadProductImage(UploadedFile $file, string $productSlug, bool $isMain = false): ?string
    {
        $prefix = $isMain ? 'main' : 'img';
        $directory = 'products/' . Str::slug($productSlug) . '/';
        
        return $this->uploadSingle($file, $directory);
    }

    /**
     * رفع صورة تصنيف
     *
     * @param UploadedFile $file
     * @param string $categorySlug
     * @return string|null
     */
    public function uploadCategoryImage(UploadedFile $file, string $categorySlug): ?string
    {
        $directory = 'categories/' . Str::slug($categorySlug) . '/';
        
        return $this->uploadSingle($file, $directory);
    }
    
    /**
     * نسخ الصورة إلى public/storage (حل لمشكلة Windows Symbolic Link)
     * 
     * @param string $path
     * @return void
     */
    private function copyToPublicStorage(string $path): void
    {
        try {
            $sourcePath = storage_path('app/public/' . $path);
            $destPath = public_path('storage/' . $path);
            
            // التأكد من وجود المجلد
            $destDir = dirname($destPath);
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            // نسخ الملف
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destPath);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to copy image to public storage: ' . $e->getMessage());
        }
    }
}

