<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'done', 'user_id', 'date', 'time'];

    protected $attributes = [
        'done' => false,
    ];

    // Accessor para formatar o campo 'time'
    public function getTimeAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('H:i') : null;
    }

    // Todo model relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
