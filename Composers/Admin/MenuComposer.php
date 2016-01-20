<?php namespace App\Composers\Admin;

use App\Models\FormPost;

/**
 * Class MenuComposer
 * @package App\Composers\Admin
 * @author Phillip Madsen
 */
class MenuComposer
{

    /**
     * @param $view
     */
    public function compose($view)
    {

        $view->with('formPost', FormPost::where('is_answered', 0)->get());
    }
}
