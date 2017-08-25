<?php

namespace DatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DatabaseBundle:Default:index.html.twig');
    }
}
