<?php namespace App\Interfaces;

/**
 * Class ModelInterface
 * @package App\Interfaces
 * @author Phillip Madsen
 */
interface ModelInterface
{

    /**
     * @param $value
     * @return mixed
     */
    public function setUrlAttribute($value);

    /**
     * @return mixed
     */
    public function getUrlAttribute();
}
