<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController 
{
    /**
     * funcion de test
     * @Config\Route(path="/home", methods={"GET"})
     *
     * @return Response
     */
    public function test(){
        return new Response(
            'asdasd', Response::HTTP_OK
        );
    }

}