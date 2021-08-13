<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\AccessMatrixManager;
use App\Manager\ActionManager;
use App\Manager\ObjectClassManager;
use App\Manager\RoleManager;
use App\Manager\WorkTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param ObjectClassManager $objectClassManager
     * @return Response
     */
    public function showTableAction(ActionManager $actionManager, RoleManager $roleManager, ObjectClassManager $objectClassManager): Response
    {
        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();
        $objectClasses = $objectClassManager->getAllObjectClass();

        return $this->render('action/table.html.twig', ['actions' => $actions, 'roles' => $roles, 'objectClasses' =>$objectClasses]);
    }

    /**
     * @Route("/table/role", methods={"GET"}, name="table_role")
     * @param Request $request
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @param ObjectClassManager $objectClassManager
     * @param AccessMatrixManager $accessMatrixManager
     * @return Response
     */
    public function showTableRole(
        Request $request,
        ActionManager $actionManager,
        RoleManager $roleManager,
        ObjectClassManager $objectClassManager,
        AccessMatrixManager $accessMatrixManager
    ): Response {
        $roleId = $request->query->get('id');

        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();
        $objectClasses = $objectClassManager->getAllObjectClass();
        $accessesMatrixByRole = $accessMatrixManager->getByRole($roleId);

        return $this->render('role/table.html.twig', [
            'actions' => $actions,
            'roles' => $roles,
            'objectClasses' =>$objectClasses,
            'accessesMatrix' => $accessesMatrixByRole
        ]);
    }

    /**
     * @Route("/work_type", methods={"GET"}, name="work_type")
     * @param WorkTypeManager $workTypeManager
     * @param Request $request
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @param ObjectClassManager $objectClassManager
     * @param AccessMatrixManager $accessMatrixManager
     */
    public function show(
        WorkTypeManager $workTypeManager,
        Request $request,
        ActionManager $actionManager,
        RoleManager $roleManager,
        ObjectClassManager $objectClassManager,
        AccessMatrixManager $accessMatrixManager
    ) {
        $roleId = $request->query->get('role');

        $workTypes = $workTypeManager->getAllWorkType();

        $actions = $actionManager->getAllActions();
        $roles = $roleManager->getAllRoles();
        $objectClasses = $objectClassManager->getAllObjectClass();
        $accessesMatrixByRole = $accessMatrixManager->getByRole($roleId);
        $accessesMatrix = [];
        foreach ($accessesMatrixByRole as $accessMatrix) {
            $accessesMatrix[] = [
                'id' => $accessMatrix->getId(),
                'role' => $accessMatrix->getRole()->getId(),
                'action' => $accessMatrix->getAction()->getId(),
                'objectClass' => $accessMatrix->getObjectClass()->getId(),
                'objectId' => $accessMatrix->getObjectId(),
                ];
        }
        $actionsArray = [];
        foreach ($actions as $action) {
            $actionsArray[] = [
                'id' => $action->getId(),
                'name' => $action->getName(),
                'signature' => $action->getSignature()
            ];
        }
        $objectClassArray = [];
        foreach ($objectClasses as $objectClass) {
            $objectClassArray[] = [
                'id' => $objectClass->getId(),
                'name' => $objectClass->getName(),
                'signature' => $objectClass->getSourceName()
            ];
        }

        return $this->json([
            'descendants' => $workTypes,
            'actions' => $actionsArray,
            'objectClasses' => $objectClassArray,
            'accessesMatrix' => $accessesMatrix
        ], Response::HTTP_OK);
    }
}