<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'source';

    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modified';

    function isSubscribed($sourceIds) {
      if(in_array($this->id, $sourceIds)) {
        return true ;
      } else {
        return false ;
      }
    }
}
