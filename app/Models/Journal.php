<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
  use HasFactory;

  protected $table = 'journal';
  protected $fillable = [
    'date',
    'title',
    'mood',
    'description',
    'user_id',
  ];

public function user()
{
  return $this->belongsTo(User::class);
}

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = ucwords($value);
  }

  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ucfirst($value);
  }
}
