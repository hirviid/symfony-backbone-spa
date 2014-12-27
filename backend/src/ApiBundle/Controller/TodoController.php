<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 27/12/2014
 * Time: 14:58
 */

namespace ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TodoController extends FOSRestController
{
    private $todos = array(
        1 => 'todo1',
        2 => 'todo2',
        3 => 'todo3'
    );

    /**
     * List all todo's.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return array
     */
    public function allAction()
    {
        $todos = $this->todos;

        $view = $this->view(array('todos' => $todos), 200);
        return $this->handleView($view);
    }

    /**
     * Get a single todo.
     *
     * @ApiDoc(
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the note is not found"
     *   }
     * )
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction($id)
    {
        if (!isset($this->todos[$id])) {
            throw new NotFoundHttpException('User not found');
        }

        $view = $this->view(array('todo' => $this->todos[$id]), 200);
        return $this->handleView($view);
    }
} 