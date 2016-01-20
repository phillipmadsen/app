<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Logger;

/**
 * Class DashboardController
 * @package App\Controllers\Admin
 * @author Phillip Madsen
 */
class DashboardController extends Controller
{



    public function __construct()
    {
        parent::__construct();
        view()->share('type', 'dashboard');
    }


    function index()
    {

        $logger = new Logger();
        /*$chartData = $logger->getLogPercent();*/

        $chartData = array();

        return view('backend/layout/dashboard', compact('chartData'))->with('active', 'home');
    }
}
