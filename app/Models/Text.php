<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $table = 'texts';
    protected $fillable = [ 'ip', 'text' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
