<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bunny extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'age_months',
        'gender',
        'image_url',
        'description',
    ];

    public function casts(): array
    {
        return [
            "price" => "decimal:2",
            "is_sold" => "boolean",
            "age_months" => "integer"
        ];
    }

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
