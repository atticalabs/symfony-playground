<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use UserRepository;

class HomeController extends AbstractController
{
    /**
     * funcion de test
     * @Config\Route(path="/home", methods={"GET"})
     *
     * @return Response
     */
    public function test(Request $request)
    {
        $firstName = $request->query->get('name');

        return new Response(
            UserRepository::findByFirstName($firstName),
            Response::HTTP_OK
        );
    }
}
