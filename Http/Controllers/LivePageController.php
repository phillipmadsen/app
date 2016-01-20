<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LivePageController extends Controller
{

/**
     * get user details and display
     */
    public function myAccount()
    {
        $user = Auth::getUser();

        return View::make('user_account', compact('user'));
    }




     /**
     * Account Register.
     *
     * @return View
     */
    public function getRegister()
    {

        // Show the page
        return View::make('login-register');
    }


    public function machine()
    {
        return view('frontend.pages.machine-frames.machine');
    }
    public function gqframe()
    {
        return view('frontend.pages.machine-frames.gq-frame');
    }
    public function compareMachineFrames()
    {
        return view('frontend.pages.machine-frames.compare-machine-frames');
    }
    public function comparison()
    {
        return view('frontend.pages.machine-frames.comparison');
    }

    // QNIQUE
    public function qnique()
    {
        return view('frontend.pages.qnique.qnique');
    }
    public function qniquefeatures()
    {
        return view('frontend.pages.qnique.features');
    }
    public function qniquespecs()
    {
        return view('frontend.pages.qnique.specs');
    }
    public function qniqueaccessories()
    {
        return view('frontend.pages.qnique.accessories');
    }

    // ECOMMERCE
    public function shop()
    {
        return view('frontend.shop');
    }

    public function cart()
    {
        return view('frontend.shop.cart');
    }
    public function newuser()
    {
        return view('frontend.newuser');
    }

    // AUTOMATION
    public function qct()
    {
        return view('frontend.pages.qct.qct');
    }
    public function qctpurchase()
    {
        return view('frontend.pages.qct.qct-purchase');
    }
    public function qctfeatures()
    {
        return view('frontend.pages.qct.qct-features');
    }
    public function qctspecs()
    {
        return view('frontend.pages.qct.qct-specs');
    }
    public function qctsupport()
    {
        return view('frontend.pages.qct.qct-support');
    }

    // HAND QUILTING
    public function handquilting()
    {
        return view('frontend.pages.hand-quilting.handquilting');
    }
    public function z44frame()
    {
        return view('frontend.pages.hand-quilting.z44-frame');
    }
    public function startrightez3()
    {
        return view('frontend.pages.hand-quilting.start-right-ez3');
    }
    public function gracehoop2()
    {
        return view('frontend.pages.hand-quilting.grace-hoop-2');
    }
    public function gracelaphoops()
    {
        return view('frontend.pages.hand-quilting.grace-lap-hoops');
    }
    public function graciebee()
    {
        return view('frontend.pages.hand-quilting.graciebee');
    }
    public function handaccessories()
    {
        return view('frontend.pages.hand-quilting.accessories');
    }
    public function comparehandframes()
    {
        return view('frontend.pages.hand-quilting.compare-frames');
    }
}
