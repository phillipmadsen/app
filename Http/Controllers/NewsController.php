<?php namespace App\Http\Controllers;

use App\Repositories\News\NewsRepository as News;
use App\Repositories\News\NewsInterface;
use Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class NewsController
 * @author Phillip Madsen
 */
class NewsController extends Controller
{

    /**
     * @var App\Repositories\News\NewsInterface
     */
    protected $news;

    /**
     * @param NewsInterface $news
     */
    public function __construct(NewsInterface $news)
    {

        $this->news = $news;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        //$news = $this->news->paginate();

        $page = Input::get('page', 1);
        $perPage = 5;
        $pagiData = $this->news->paginate($page, $perPage, false);

        $news = new LengthAwarePaginator($pagiData->items, $pagiData->totalItems, $perPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        $news->setPath("");

        return view('frontend.news.index', compact('news'));
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {

        $news = $this->news->getBySlug($slug);

        if ($news === null) {
            return Response::view('errors.missing', array(), 404);
        }

        return view('frontend.news.show', compact('news'));
    }
}
