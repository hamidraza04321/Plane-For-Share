<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = [ 'ip', 'name', 'source' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
