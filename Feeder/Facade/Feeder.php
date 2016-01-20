<?php namespace App\Feeder\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Feeder
 * @package App\Facades
 * @author Phillip Madsen
 */
class Feeder extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {

        return 'feeder';
    }
}
