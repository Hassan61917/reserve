<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminRoleRequest;
use App\Http\Resources\v1\RoleResource;
use App\Models\Role;
use App\ModelServices\User\RoleService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminRoleController extends Controller
{
    protected string $resource = RoleResource::class;

    public function __construct(
        public RoleService $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAll()->withCount("users");
        return $this->ok($this->paginate($roles));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $role = $this->roleService->make($data);
        return $this->ok($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        $role->load("users")->loadCount("users");
        return $this->ok($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleRequest $request, Role $role): JsonResponse
    {
        $data = $request->validated();
        $role->update($data);
        return $this->ok($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return $this->deleted();
    }
}
