<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemeVariable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'variable_key',
        'default_value',
        'section_theme_id',
        'type',
        'description',
    ];

    /**
     * Get the theme for this variable
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(SectionTheme::class, 'section_theme_id');
    }
}
