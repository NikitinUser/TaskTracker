<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Throwable;
use App\DTO\ResponseDTO;
use App\Services\TaskService;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Transformers\CreateTaskRequestTransformer;
use App\Transformers\UpdateTaskRequestTransformer;

class TaskController extends Controller
{
    private ResponseDTO $responseDto;

    private TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->responseDto = new ResponseDTO();
        $this->service = $service;
    }

    public function getAll(): JsonResponse
    {
        try {
            $userId = auth()->user()->id;
            $this->responseDto->data = $this->service->getAll($userId);
        } catch (Throwable $t) {
            $this->responseDto->error = $t->getMessage();
            $this->responseDto->code = 500;
        }
        
        return response()->json($this->responseDto, $this->responseDto->code);
    }

    public function create(
        CreateTaskRequest $request,
        CreateTaskRequestTransformer $transformer
    ): JsonResponse {
        try {
            $dto = $transformer->transform($request->all(), auth()->user()->id);
            $this->responseDto->data = $this->service->create($dto);
        } catch (Throwable $t) {
            $this->responseDto->error = $t->getMessage();
            $this->responseDto->code = 500;
        }
        
        return response()->json($this->responseDto, $this->responseDto->code);
    }

    public function update(
        UpdateTaskRequest $request,
        UpdateTaskRequestTransformer $transformer
    ): JsonResponse {
        try {
            $dto = $transformer->transform($request->all(), auth()->user()->id);
            $this->service->update($dto);
        } catch (Throwable $t) {
            $this->responseDto->error = $t->getMessage();
            $this->responseDto->code = 500;
        }
        
        return response()->json($this->responseDto, $this->responseDto->code);
    }

    public function delete(int $taskId): JsonResponse
    {
        try {
            $userId = auth()->user()->id;
            $this->service->delete($userId, $taskId);
        } catch (Throwable $t) {
            $this->responseDto->error = $t->getMessage();
            $this->responseDto->code = 500;
        }
        
        return response()->json($this->responseDto, $this->responseDto->code);
    }
}
