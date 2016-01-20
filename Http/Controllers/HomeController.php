<?php namespace App\Http\Controllers;

use App\Repositories\Project\ProjectInterface;
use App\Repositories\Slider\SliderInterface;
use LaravelLocalization;

/**
 * Class HomeController
 * @author Phillip Madsen
 */
class HomeController extends Controller
{

    protected $slider;
    protected $project;

    public function __construct(SliderInterface $slider, ProjectInterface $project)
    {

        $this->slider = $slider;
        $this->project = $project;
    }

    public function index()
    {

        $languages=LaravelLocalization::getSupportedLocales();

        $sliders = $this->slider->all();
        $projects = $this->project->all();

        return view('frontend/layout/dashboard', compact('sliders', 'projects', 'languages'));
    }
}
