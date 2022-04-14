<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\RatingAspectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("api/projects")
 */
class ProjectController extends BaseController
{

    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("", methods={"GET"})
     * @OA\Get(
     *     path="/api/projects",
     *     description="Use this API to get the projects",
     *     @OA\Response(
     *          response="200",
     *          description="You will receive an array of the projects"
     *      ),
     * )
     */
    public function index(Request $request)
    {
        $projects = $this->projectRepository->findAll(['id', 'title']);
        return $this->successResponse($projects);
    }
}