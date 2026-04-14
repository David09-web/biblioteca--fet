<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'student_name',
        'phone',
        'id_number',
        'carnet_photo_path',
        'checkout_date',
        'due_date',
        'return_date',
        'status',
    ];

    protected $casts = [
        'checkout_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
