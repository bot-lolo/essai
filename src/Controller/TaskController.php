<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
    #[Route('/task/{slug}}', name: '_ta')]
    public function show(Request $request, Task $task, TaskRepository $taskRepository)
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $form=$this->createForm(TaskFormType::class, $task);
        $offset = max(0, $request->query->getInt('offset', 0));
         $paginator = $taskRepository->getTaskPaginator($task, $offset);

    

    }
}
