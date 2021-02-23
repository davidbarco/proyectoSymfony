<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

class TaskController extends AbstractController
{
    /* todas las tareas */
    public function index(): Response{
        /* prueba de entidades y relaciones */
        /* sacar todas las tareas que tengo en mi base de datos*/
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([],['id'=>'DESC']);
       
        return $this->render('task/index.html.twig', [
            'tasks'=> $tasks
        ]);
    }

    /* detalle de cada tarea */
    public function detail(Task $task){
        if(!$task){
           return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig',[
            'task' => $task
        ]);
          
    }

    /* metodo para crear tareas */
    public function creation(Request $request, UserInterface  $user ){
         /* crear formulario */
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        /* vincular el formulario con el objeto */
        $form->handleRequest($request);

         /* compruebo si el formulario ha sido enviado */
         if($form->isSubmitted() && $form->isValid()){
            /* recogo la informacion y la asigno a mi tabla users de la base de datos */
            $task->setCreatedAt(new DateTime('now'));
            $task->setUser($user);
            
             /* guardar usuario en base de datos */
             $em = $this->getDoctrine()->getManager();
             $em->persist($task);
             $em->flush();

              /* despues de que me guarde en base de datos, que me redigira */
            return $this->redirect($this->generateUrl('task_detail',['id'=> $task->getId()]));

        }

        return $this->render('task/creation.html.twig', [
            'form'=> $form->createView()
        ]);
}


    /* metodo para listar todas mis tareas, las tareas del usuario logeado */
    public function myTasks(UserInterface $user){
        
        
        $tasks = $user->getTasks();

        return $this->render('task/my-tasks.html.twig', [
            'tasks'=> $tasks
        ]);


    }


    /* metodo para editar una tarea */
    public function edit(Request $request, UserInterface $user, Task $task){
        if(!$user || $user->getId() != $task->getUser()->getId()){

            return $this->redirectToRoute('tasks');

        }else{

            $form = $this->createForm(TaskType::class, $task);
    
            /* vincular el formulario con el objeto */
            $form->handleRequest($request);
    
             /* compruebo si el formulario ha sido enviado */
             if($form->isSubmitted() && $form->isValid()){
               
                
                 /* guardar usuario en base de datos */
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($task);
                 $em->flush();
                  /* despues de que me guarde en base de datos, que me redigira */
                return $this->redirect($this->generateUrl('task_detail',['id'=> $task->getId()]));

            }
        }


        /* renderizamos vista */
        return $this->render('task/creation.html.twig', [
            'edit'=> true,
            'form'=> $form->createView()
        ]);

    }


    /* metodo para borrar una tarea, cuando soy el dueño de la tarea */
    public function delete(UserInterface $user, Task $task){

        if(!$user || $user->getId() != $task->getUser()->getId()){

            return $this->redirectToRoute('tasks');

        }

        if(!$task){
            return $this->redirectToRoute('tasks');
        }

            /* guardar usuario en base de datos */
            $em = $this->getDoctrine()->getManager();

            /* elimino el objeto de doctrine */
            $em->remove($task);
            /* elimino el objeto de la base de datos */
            $em->flush();

            return $this->redirectToRoute('tasks');





    }
    





}
