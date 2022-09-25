<?php


namespace App\Http\Interfaces;


interface TaskInterface
{
    public function allTasks($request);

    public function specificTask($request);

    public function addTask($request);

    public function updateTask($request);

    public function deleteTask($request);

    public function updateTaskStatus($request);

}
