<?php namespace App\Composers;

use Menu;
use Page;
use PhotoGallery;
use FormPost;
use App\Repositories\Menu\MenuInterface;

/**
 * Class MenuComposer
 * @package App\Composers
 * @author Phillip Madsen
 */
class MenuComposer
{

    /**
     * @var \App\Repositories\Menu\MenuInterface
     */
    protected $menu;

    /**
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu)
    {

        $this->menu=$menu;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {

        $items = $this->menu->all();
        $menus = $this->menu->getFrontMenuHTML($items);
        $view->with('menus', $menus);
    }
}
