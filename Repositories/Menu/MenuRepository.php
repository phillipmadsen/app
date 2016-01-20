<?php namespace App\Repositories\Menu;

use App\Models\Menu;
use Config;
use Response;
use App\Models\Tag;
use App\Models\Category;
use Str;
use Event;
use Image;
use File;
use App\Repositories\RepositoryAbstract;
use App\Repositories\CrudableInterface as CrudableInterface;
use App\Repositories\RepositoryInterface as RepositoryInterface;
use App\Exceptions\Validation\ValidationException;
use App\Repositories\AbstractValidator as Validator;

/**
 * Class MenuRepository
 * @package App\Repositories\Menu
 *
 */
class MenuRepository extends RepositoryAbstract implements MenuInterface
{

    /**
     * @var \Menu
     */
    protected $menu;

    /**
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {

        $this->menu = $menu;
    }

    /**
     * @return mixed
     */
    public function all()
    {

        return $this->menu->where('is_published', 1)->where('lang', $this->getLang())->orderBy('order', 'asc')->get();
    }

    /**
     * @param $menu
     * @param int $parentId
     * @param bool $starter
     * @return null|string
     */
    public function generateFrontMenu($menu, $parentId = 0, $starter = false)
    {

        $result = null;

        foreach ($menu as $item) {
            if ($item->parent_id == $parentId) {
                $childItem = $this->hasChildItems($item->id);

                $result .= "<li " . (($childItem) ? '  class="sub-menu" ' : '') . (($childItem && $item->parent_id != 0) ? '  ' : null) . ">
                                <a href='" . url($item->url) . "' " . (($childItem) ? 'class="sf-with-ul" ' : null) . ">{$item->title}" . (($childItem && $item->parent_id == 0) ? '<b class="caret"></b>' : null) . "</a>" . $this->generateFrontMenu($menu, $item->id) . "
                            </li>";




            }
        }

        return $result ? "\n<ul  style='touch-action: pan-y;' class='" . (($starter) ? ' sf-js-enabled  ' : null) . ((!$starter) ? ' dropdown-menu ' : null) . "'>\n$result</ul>\n" : null;
    }

    /**
     * @param $items
     * @return null|string
     */
    public function getFrontMenuHTML($items)
    {

        return $this->generateFrontMenu($items, 0, true);
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasChildItems($id)
    {

        $count = $this->menu->where('parent_id', $id)->where('is_published', 1)->where('lang', $this->getLang())->get()->count();
        if ($count === 0) {
            return false;
        }
        return true;
    }
}


//<li class="sub-menu"><a href="index.html" class="sf-with-ul"><div>Home</div></a>
//    </li>
//    <li class="current sub-menu"><a href="#" class="sf-with-ul"><div>Features</div></a>
//    </li>
//    <li class="mega-menu sub-menu"><a href="#" class="sf-with-ul"><div>Pages</div></a>
//    </li>
//    <li class="mega-menu sub-menu"><a href="#" class="sf-with-ul"><div>Portfolio</div></a>
//    </li>
//    <li class="mega-menu sub-menu"><a href="#" class="sf-with-ul"><div>Blog</div></a>
//    </li>
//    <li class="sub-menu"><a href="shop.html" class="sf-with-ul"><div>Shop</div></a>
//    </li>
//    <li class="mega-menu sub-menu"><a href="#" class="sf-with-ul"><div>Shortcodes</div></a>
//    </li>
//</ul>
