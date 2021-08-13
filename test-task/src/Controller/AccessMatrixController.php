<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\AccessMatrixManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessMatrixController extends AbstractController
{
    /**
     * @Route("/create", methods={"GET"}, name="access_matrix_create")
     * @throws \Exception
     */
    public function createAction(Request $request, AccessMatrixManager $accessMatrixManager): Response
    {
        $arguments = $request->query->all();
        $accessMatrixManager->create($arguments);

        return new Response();
    }

    /**
     * @Route("/delete", methods={"GET"}, name="access_matrix_delete")
     * @throws \Exception
     */
    public function deleteAction(Request $request, AccessMatrixManager $accessMatrixManager): Response
    {
        $arguments = $request->query->all();
        $accessMatrixManager->delete($arguments);

        return new Response();
    }
}