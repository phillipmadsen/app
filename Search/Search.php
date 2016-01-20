<?php namespace App\Search;

use App\Models\News;
use App\Models\Article;
use App\Models\PhotoGallery;

/**
 * Class Search
 * @package App\Search
 * @author Phillip Madsen
 */
class Search
{

    public function search($search)
    {

        $newsResult = News::search($search)->get()->toArray();
        $articleResult = Article::search($search)->get()->toArray();
        $photoGalleryResult = PhotoGallery::search($search)->get()->toArray();
        $result = array_merge($newsResult, $articleResult, $photoGalleryResult);
        return $result;
    }
}
