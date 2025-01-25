<?php

namespace App\Http\Controllers;

use App\CanLoadRelationships;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use AuthorizesRequests;
    use CanLoadRelationships;

    public function __construct()
    {   
        $this->authorizeResource(Task::class, 'task');
    }
    
    /**
     * Endpoint for view all tasks.
     * @queryParam is_done boolean Optional. Filter by done task. Example: 1
     * @queryParam include string Optional. Load relationships. Example: user
     * @queryParam page integer Optional. Paginate page. Example: 1
     * 
     * @return void
     * @authenticated
     */
    public function index()
    {
        $is_done = request()->boolean('is_done', null);
        $is_done = is_null($is_done) ? [1, 0] : [$is_done];

        $query = $this->loadRelationships(Task::query(), ['user']);

        $tasks = $query->whereIn('is_done', $is_done)
            ->paginate(5);

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'Tasks not found.',
            ], 404);
        }

        return response()->json([
            'tasks' => TaskResource::collection($tasks),
        ]);
    }
        
    /**
     * Endpoint for view some task only current user
     *
     * @param  mixed $task
     * @return void
     * @authenticated
     */
    public function show(Task $task)
    {
        return response()->json([
            'task' => $task,
        ]);
    }
    
    /**
     * Endpoint for create new task
     *
     * @param  mixed $request
     * @return void
     * @authenticated
     */
    public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::user()->id;

        $task = Task::create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], Response::HTTP_CREATED);
    }
    
    /**
     * Endpoint for update task
     *
     * @param  mixed $request
     * @param  mixed $task
     * @return void
     * @authenticated
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ], Response::HTTP_OK);
    }
    
    /**
     * Endpoint for delete task
     *
     * @param  mixed $task
     * @return void
     * @authenticated
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
