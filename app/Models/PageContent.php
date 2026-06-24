<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'page',
        'section',
        'content',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get all active sections for a given page, ordered by sort_order.
     */
    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    /**
     * Get a single section's content for a given page.
     * Returns an array or null if not found.
     */
    public static function getSection(string $page, string $section): ?array
    {
        return Cache::remember("page_content.{$page}.{$section}", 3600, function () use ($page, $section) {
            $record = static::where('page', $page)
                ->where('section', $section)
                ->where('is_active', true)
                ->first();

            return $record?->content;
        });
    }

    /**
     * Get all sections for a given page as a keyed array [section => content].
     */
    public static function getPage(string $page): array
    {
        return Cache::remember("page_content.{$page}", 3600, function () use ($page) {
            $records = static::forPage($page)->get();

            return $records->pluck('content', 'section')->toArray();
        });
    }

    /**
     * Get a specific value from a section's content by key.
     */
    public static function getValue(string $page, string $section, string $key, mixed $default = null): mixed
    {
        $content = static::getSection($page, $section);

        return $content[$key] ?? $default;
    }

    /**
     * Clear the cache for a given page/section.
     */
    public static function clearCache(string $page, ?string $section = null): void
    {
        if ($section) {
            Cache::forget("page_content.{$page}.{$section}");
        }
        Cache::forget("page_content.{$page}");
    }

    /**
     * The "booted" method to auto-clear cache on save/delete.
     */
    protected static function booted(): void
    {
        static::saved(function ($pageContent) {
            $pageContent->clearCacheOnChange();
        });

        static::deleted(function ($pageContent) {
            $pageContent->clearCacheOnChange();
        });
    }

    /**
     * Clear cache for this record's page and section.
     */
    protected function clearCacheOnChange(): void
    {
        static::clearCache($this->page, $this->section);
    }
}
