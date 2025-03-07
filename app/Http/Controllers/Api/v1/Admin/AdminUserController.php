<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\Role;
use App\Models\User;
use App\ModelServices\User\UserService;
use Illuminate\Http\JsonResponse;

class AdminUserController extends Controller
{
    protected string $resource = UserResource::class;

    public function __construct(
        private UserService $userService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAll(["roles"]);
        return $this->ok($this->paginate($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->create($data, Role::find($data['role_id']));
        $user->load("roles");
        return $this->ok($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['roles']);
        return $this->ok($user);
    }

    public function addRole(User $user, Role $role): JsonResponse
    {
        if ($this->isSameUser($user)) {
            return $this->error(403, "role can not be added");
        }
        $user->load("roles");
        $this->userService->addRole($user, $role);
        return $this->ok($user);
    }

    public function removeRole(User $user, Role $role): JsonResponse
    {
        if ($this->isSameUser($user)) {
            return $this->error(403, "role can not be removed");
        }
        $user->load("roles");
        $this->userService->removeRole($user, $role);
        return $this->ok($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user->update($data);
        return $this->ok($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if ($this->isSameUser($user)) {
            return $this->error(403, "user can not be deleted");
        }
        $user->delete();
        return $this->deleted();
    }

    private function isSameUser(User $user): bool
    {
        return $this->authUser()->is($user);
    }
}
