<?php namespace App\Http\Controllers;

use App\Repositories\PhotoGallery\PhotoGalleryRepository as PhotoGallery;
use App\Repositories\PhotoGallery\PhotoGalleryInterface;
use Response;

/**
 * Class PhotoGalleryController
 * @author Phillip Madsen
 */
class PhotoGalleryController extends Controller
{

    /**
     * @var App\Repositories\PhotoGallery\PhotoGalleryInterface
     */
    protected $photoGallery;

    /**
     * @param PhotoGalleryInterface $photoGallery
     */
    public function __construct(PhotoGalleryInterface $photoGallery)
    {

        $this->photoGallery = $photoGallery;
    }

    /**
     * Display photo gallery
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {

        $photo_gallery = $this->photoGallery->getBySlug($slug);

        if ($photo_gallery === null) {
            return Response::view('errors.missing', array(), 404);
        }

        return view('frontend.photo_gallery.show', compact('photo_gallery'));
    }
}
