<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\AccessMatrixManager;
use App\Manager\ActionManager;
use App\Manager\BidManager;
use App\Manager\ObjectClassManager;
use App\Manager\RoleManager;
use App\Manager\WorksCtoManager;
use App\Manager\WorkTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param ObjectClassManager $objectClassManager
     * @param AccessMatrixManager $accessMatrixManager
     * @return JsonResponse
     */
    public function showWorkType(
        WorkTypeManager $workTypeManager,
        Request $request,
        ActionManager $actionManager,
        ObjectClassManager $objectClassManager,
        AccessMatrixManager $accessMatrixManager
    ): JsonResponse {
        $roleId = $request->query->get('role');

        $workTypes = $workTypeManager->getAll();

        $accessesMatrix = $accessMatrixManager->toArray($roleId);
        $actionsArray = $actionManager->toArray();
        $objectClasses = $objectClassManager->toArray();

        return $this->json([
            'descendants' => $workTypes,
            'actions' => $actionsArray,
            'objectClasses' => $objectClasses,
            'accessesMatrix' => $accessesMatrix
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/bid", methods={"GET"}, name="bid")
     * @param BidManager $bidManager,
     * @param Request $request
     * @param ActionManager $actionManager
     * @param ObjectClassManager $objectClassManager
     * @param AccessMatrixManager $accessMatrixManager
     * @return JsonResponse
     */
    public function showBid(
        BidManager $bidManager,
        Request $request,
        ActionManager $actionManager,
        ObjectClassManager $objectClassManager,
        AccessMatrixManager $accessMatrixManager
    ): JsonResponse {
        $roleId = $request->query->get('role');

        $bid = $bidManager->getAll();

        $accessesMatrix = $accessMatrixManager->toArray($roleId);
        $actionsArray = $actionManager->toArray();
        $objectClasses = $objectClassManager->toArray();

        return $this->json([
            'descendants' => $bid,
            'actions' => $actionsArray,
            'objectClasses' => $objectClasses,
            'accessesMatrix' => $accessesMatrix
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/works_cto", methods={"GET"}, name="work_cto")
     * @param WorksCtoManager $workCtoManager
     * @param Request $request
     * @param ActionManager $actionManager
     * @param ObjectClassManager $objectClassManager
     * @param AccessMatrixManager $accessMatrixManager
     * @return JsonResponse
     */
    public function showWorkCto(
        WorksCtoManager $workCtoManager,
        Request $request,
        ActionManager $actionManager,
        ObjectClassManager $objectClassManager,
        AccessMatrixManager $accessMatrixManager
    ): JsonResponse {
        $roleId = $request->query->get('role');

        $workCto = $workCtoManager->getAll();

        $accessesMatrix = $accessMatrixManager->toArray($roleId);
        $actionsArray = $actionManager->toArray();
        $objectClasses = $objectClassManager->toArray();

        return $this->json([
            'descendants' => $workCto,
            'actions' => $actionsArray,
            'objectClasses' => $objectClasses,
            'accessesMatrix' => $accessesMatrix
        ], Response::HTTP_OK);
    }
}