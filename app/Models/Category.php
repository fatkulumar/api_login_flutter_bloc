<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use GenUid;
    
    protected $fillable = [
        'name'
    ];
}
