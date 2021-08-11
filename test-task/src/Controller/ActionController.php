<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\ActionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionController extends AbstractController
{
    /**
     * @Route("/action", methods={"GET"}, name="filter_action")
     * @param ActionManager $manager
     * @return Response
     */
    public function indexAction(ActionManager $manager): Response
    {
        $actions = $manager->getAllActions();

        return $this->render('action/index.html.twig', ['actions' => $actions]);
    }
}