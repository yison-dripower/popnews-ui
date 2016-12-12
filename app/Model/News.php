<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modified';
}
