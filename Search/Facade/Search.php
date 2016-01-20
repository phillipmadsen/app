<?php namespace App\Search\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Search
 * @package App\Facades
 * @author Phillip Madsen
 */
class Search extends Facade
{

    protected static function getFacadeAccessor()
    {

        return 'search';
    }
}
