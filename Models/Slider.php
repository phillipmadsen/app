<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider
 * @author Phillip Madsen
 */
class Slider extends Model
{

    public $table = 'sliders';

    public function images()
    {

        return $this->morphMany('App\Models\Photo', 'relationship', 'type');
    }
}
