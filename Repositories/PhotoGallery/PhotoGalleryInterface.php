<?php namespace App\Repositories\PhotoGallery;

use App\Repositories\RepositoryInterface;

/**
 * Interface PhotoGalleryInterface
 * @package App\Repositories\PhotoGallery
 * @author Phillip Madsen
 */
interface PhotoGalleryInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}
