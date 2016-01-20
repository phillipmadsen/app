<?php namespace App\Repositories\Article;

use App\Repositories\RepositoryInterface;

/**
 * Interface ArticleInterface
 * @package App\Repositories\Article
 * @author Phillip Madsen
 */
interface ArticleInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}
