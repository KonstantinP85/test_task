<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", methods={"GET"}, name="filter_role")
     * @param RoleManager $manager
     * @return Response
     */
    public function indexAction(RoleManager $manager): Response
    {

        $forRender = [];
        return $this->render('role/index.html.twig', $forRender);
    }
}