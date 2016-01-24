<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribe';

    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modified';
}
