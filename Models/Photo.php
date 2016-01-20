<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @author Phillip Madsen
 */
class Photo extends Model
{

    public $table = 'photos';
    public $timestamps = false;

    public function slider()
    {

        return $this->morphTo('App\Models\Slider', 'relationship');
    }

    public function photo_gallery()
    {

        return $this->morphTo('App\Models\PhotoGallery', 'relationship');
    }
}
