<?php namespace App\LogViewer\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class LogViewer
 * @package App\Facades
 * @author Phillip Madsen
 */
class LogViewer extends Facade
{

    protected static function getFacadeAccessor()
    {

        return 'logviewer';
    }
}
