<?php namespace App\Composers;

use News;
use App\Repositories\News\NewsInterface;

/**
 * Class MenuComposer
 * @package App\Composers
 * @author Phillip Madsen
 */
class NewsComposer
{

    /**
     * @var \App\Repositories\News\NewsInterface
     */
    protected $news;

    /**
     * @param ArticleInterface $article
     */
    public function __construct(NewsInterface $news)
    {

        $this->news = $news;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {

        $news = $this->news->getLastNews(5);
        $view->with('news', $news);
    }
}
