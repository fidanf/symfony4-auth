<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     */
    public function index() 
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile()
    {
        return $this->render('user/profile.html.twig');
    }
}