<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CasesInterface;
use App\Http\Interfaces\CompanyInterface;
use App\Http\Interfaces\TaskInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskInterface;

    public function __construct(TaskInterface $taskInterface)
    {
        $this->taskInterface = $taskInterface;
    }

    public function allTasks(Request $request)
    {
        return $this->taskInterface->allTasks($request);
    }

    public function specificTask(Request $request)
    {
        return $this->taskInterface->specificTask($request);
    }

    public function addTask(Request $request)
    {
        return $this->taskInterface->addTask($request);
    }

    public function updateTask(Request $request)
    {
        return $this->taskInterface->updateTask($request);
    }

    public function deleteTask(Request $request)
    {
        return $this->taskInterface->deleteTask($request);
    }

    public function updateTaskStatus(Request $request)
    {
        return $this->taskInterface->updateTaskStatus($request);
    }

}
