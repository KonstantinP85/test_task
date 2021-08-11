<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\ActionManager;
use App\Manager\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="main")
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @return Response
     */
    public function indexAction(ActionManager $actionManager, RoleManager $roleManager): Response
    {
        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();

        return $this->render('base.html.twig', ['actions' => $actions, 'roles' => $roles]);
    }

    /**
     * @Route("/table/action", methods={"GET"}, name="table_action")
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @return Response
     */
    public function showTableAction(ActionManager $actionManager, RoleManager $roleManager): Response
    {
        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();

        return $this->render('action/table.html.twig', ['actions' => $actions, 'roles' => $roles]);
    }

    /**
     * @Route("/table/role", methods={"GET"}, name="table_role")
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @return Response
     */
    public function showTableRole(ActionManager $actionManager, RoleManager $roleManager): Response
    {
        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();

        return $this->render('role/table.html.twig', ['actions' => $actions, 'roles' => $roles]);
    }
}