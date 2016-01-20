<?php namespace App\Repositories\Menu;

use App\Repositories\RepositoryInterface;

/**
 * Interface MenuInterface
 * @package App\Repositories\Menu
 *
 */
interface MenuInterface {

    /**
     * Get all menu items
     * @return mixed
     */
    public function all();
}