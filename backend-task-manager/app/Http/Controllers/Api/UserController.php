<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            $request->validated()
        );

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ]);
    }
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user,
        ]);
    }
    public function update(
        UpdateUserRequest $request,
        User $user
    ): JsonResponse {
        $updatedUser = $this->userService->update(
            $user,
            $request->validated()
        );

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $updatedUser,
        ], 200);
    }
    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
