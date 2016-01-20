<?php namespace App\Repositories\Video;

use App\Repositories\RepositoryInterface;

/**
 * Interface VideoInterface
 * @package App\Repositories\Video
 * @author Phillip Madsen
 */
interface VideoInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}
