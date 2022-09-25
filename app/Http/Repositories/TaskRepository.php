<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\CasesInterface;
use App\Http\Interfaces\CompanyInterface;
use App\Http\Interfaces\TaskInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileUploaderTrait;
use App\Models\case_staff;
use App\Models\cases;
use App\Models\company_case;
use App\Models\task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskRepository implements TaskInterface
{
    use ApiResponseTrait;
    use FileUploaderTrait;


    /**
     * @var case_staff
     */
    private $taskModel;
    private $cases_model;
    private $company_cases_model;

    public function __construct(task $task, company_case $company_case)
    {
        $this->taskModel = $task;
        $this->company_cases_model = $company_case;
    }


    public function allTasks($request)
    {
        $tasks = $this->taskModel::with('userData')->get();

        return $this->apiResponse(200, 'Done', null, $tasks);
    }

    public function specificTask($request)
    {
        $validation = Validator::make($request->all(),[
            'task_id' => 'required|exists:tasks,id',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422,'Validation Error', $validation->errors());
        }

        $task = $this->taskModel::where('id', $request->task_id)->with('userData')->first();

        return $this->apiResponse(200, 'Done', null, $task);
    }

    public function addTask($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
            'file' => 'required',
            'body' => 'required',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422,'Validation Error', $validation->errors());
        }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $taskFile = $this->uploadFile($file, 'Hakiba/Tasks');
        }

        $this->taskModel::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'body' => $request->body,
            'file' => $taskFile,
        ]);

        return $this->apiResponse(200, 'created');

    }

    public function updateTask($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
            'file' => 'required',
            'body' => 'required',
            'task_id' => 'required|exists:tasks,id',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422,'Validation Error', $validation->errors());
        }

        $task = $this->taskModel::find($request->task_id);

        $taskFile = $task->file;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $taskFile = $this->uploadFile($file, 'Hakiba/Tasks');
        }

        $task->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'body' => $request->body,
            'file' => $taskFile,
        ]);

        return $this->apiResponse(200, 'Updated');
    }

    public function deleteTask($request)
    {
        $validation = Validator::make($request->all(),[
            'task_id' => 'required|exists:tasks,id',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422,'Validation Error', $validation->errors());
        }

       $this->taskModel::find($request->task_id)->delete();

        return $this->apiResponse(200, 'Deleted');
    }

    public function updateTaskStatus($request)
    {
        $validation = Validator::make($request->all(),[
            'task_id' => 'required|exists:tasks,id',
        ]);

        if($validation->fails()){
            return $this->apiResponse(422,'Validation Error', $validation->errors());
        }

        $this->taskModel::find($request->task_id)->update([
            'status' => 1
        ]);

        return $this->apiResponse(200, 'Updated');
    }
}
