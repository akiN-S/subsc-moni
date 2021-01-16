<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'subscId',
        'contentLocalId',
        'contentName'
    ]; 
}
