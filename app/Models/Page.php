<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class Page extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['title', 'content', 'description', 'uri', 'foto'];
}
