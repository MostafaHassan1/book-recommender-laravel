<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeMostRead(Builder $query): Builder
    {
        return $query->orderBy('number_of_read_pages', 'desc');
    }

    public function readingIntervals(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isFullyRead(): bool
    {
        return $this->number_of_read_pages == $this->number_of_pages;
    }
}
