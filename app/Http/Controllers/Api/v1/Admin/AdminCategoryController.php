<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class AdminCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()->withCount('children');
        return $this->ok($this->paginate($categories));
    }

    public function store(AdminCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $category = Category::create($data);
        return $this->ok($category);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load('children')->loadCount("children");
        return $this->ok($category);
    }

    public function update(AdminCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();
        $category->update($data);
        return $this->ok($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->deleted();
    }
}
