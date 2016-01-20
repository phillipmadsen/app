<?php namespace App\Repositories\Page;

use App\Repositories\RepositoryInterface;

/**
 * Interface PageInterface
 * @package App\Repositories\Page
 * @author Phillip Madsen
 */
interface PageInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug, $isPublished = false);
}
