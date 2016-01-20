<?php namespace App\Repositories\Project;

use App\Repositories\RepositoryInterface;

/**
 * Interface ProjectInterface
 * @package App\Repositories\Project
 * @author Phillip Madsen
 */
interface ProjectInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}
