<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modified';

    static function validate($name, $password) {
      $user = self::where('name', $name)
        ->where('password', md5($password))
        ->first();
      if(! empty($user)) {
        return true;
      } else {
        return false;
      }
    }

    static function check() {
      return ! empty($_SESSION['user']);
    }

    static function getByName($name) {
      return self::whereName($name)->first();
    }

}
