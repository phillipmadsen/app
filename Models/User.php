<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

/**
 * Class User
 * @package App\Models
 * @author Phillip Madsen <karagozsefa@gmail.com>
 */
class User extends EloquentUser
{

/**
 * Relationship with the Profile model.
 *
 * @author  Phillip Madsen
 * @return  Illuminate\Database\Eloquent\Relations\HasOne
 */
    public function profile()
    {
        return $this->hasOne('Profile');
    }
}
