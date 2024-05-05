<?php

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
        return self::where('id','!=',$this->id)
            ->where('book_id',$this->book_id)
            ->where('merged',false) // used to ignore any interval that already got operated on by another intersected interval and merged with it
            ->where(function ($subQuery) {
                $subQuery->whereBetween('start_page', [$this->start_page, $this->end_page])
                    ->orWhereBetween('end_page', [$this->start_page, $this->end_page]);
            })->get();
    }

    public function merged()
    {
        $this->update(['merged' => true]);
    }

    protected function startPage(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value == 1 ? 0 : $value,
            set: fn(int $value) => $value == 0 ? 1 : $value
        );
    }
}
