<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use App\Observers\ReadingIntervalObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ReadingIntervalObserver::class])]
class ReadingInterval extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getIntersectingReadingIntervals()
    {
        return self::where('id', '<', $this->id) // only older intervals than this one
            ->where('book_id', $this->book_id)
            ->where('merged', false) // used to ignore any interval that already got operated on by another intersected interval and merged with it
            ->where(function ($subQuery): void {
                $subQuery->whereBetween('start_page', [$this->start_page, $this->end_page])
                    ->orWhereBetween('end_page', [$this->start_page, $this->end_page])
                ;
            })->get()
        ;
    }

    public function merged(): void
    {
        $this->update(['merged' => true]);
    }

    protected function startPage(): Attribute
    {
        return Attribute::make(
            get: static fn (int $value) => 1 === $value ? 0 : $value,
            set: static fn (int $value) => 0 === $value ? 1 : $value
        );
    }
}
