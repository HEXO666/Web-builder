<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'published',
        'export_path',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Get the user who owns the website
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all sections for this website
     */
    public function sections(): HasMany
    {
        return $this->hasMany(WebsiteSection::class, 'website_id')->orderBy('order');
    }
}
