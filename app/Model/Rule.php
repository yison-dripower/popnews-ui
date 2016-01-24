<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rule';

    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modified';
}
