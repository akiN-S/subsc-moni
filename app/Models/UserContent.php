<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'subscContentId',
        'contentName',
        'userId',
        'currentContent',
        'lastContent',
        'watched'
    ]; 

}
