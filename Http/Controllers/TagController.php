<?php namespace App\Http\Controllers;

use App\Repositories\Tag\TagInterface;
use App\Repositories\Tag\TagRepository as Tag;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class TagController
 * @author Phillip Madsen
 */
class TagController extends Controller
{

    protected $tag;
    protected $category;

    public function __construct(TagInterface $tag, CategoryInterface $category)
    {

        $this->tag = $tag;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($slug)
    {

        $articles = $this->tag->getArticlesBySlug($slug);
        $categories = $this->category->all();
        $tags = $this->tag->all();
        return view('frontend.tag.index', compact('articles', 'tags', 'categories'));
    }
}
