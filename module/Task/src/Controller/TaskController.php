<?php

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Task\Form\TaskForm;
use Task\Model\Task;
use Task\Model\TaskTable;



class TaskController extends AbstractActionController
{
    
    private $taskTable;

    const WORKDAYS = [
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
    ];

    public function __construct(TaskTable $taskTable)
    {
        $this->taskTable = $taskTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'tasks' => $this->taskTable->fetchAll(),
        ]);
    }

    
    public function myAction()
    {
        return new ViewModel([
            'tasks' => $this->taskTable->fetchAllByUser($this->identity()->id),
        ]);
    }

    public function workdaysAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $date = (new \DateTime())->format('D');
        if (!in_array($date, TaskController::WORKDAYS)){
            return $this->redirect()->toRoute('task', ['action' => 'workdays']);
        }
        $form = new TaskForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $task = new Task();
        $form->setInputFilter($task->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $task->exchangeArray($form->getData());
        $this->taskTable->saveTask($task, $this->identity()->id);
        return $this->redirect()->toRoute('task', ['action' => 'my']);
    }

    public function editAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('task', ['action' => 'add']);
        }
        try {
            $task = $this->taskTable->getTask($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('task', ['action' => 'my']);
        }

        $form = new TaskForm();
        $form->bind($task);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($task->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->taskTable->saveTask($task);

        // Redirect to task list
        return $this->redirect()->toRoute('task', ['action' => 'my']);

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('task', ['action' => 'my']);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->taskTable->deleteTask($id);
            }

            return $this->redirect()->toRoute('task', ['action' => 'my']);
        }

        return [
            'id'    => $id,
            'task' => $this->taskTable->getTask($id),
        ];
    }
}
