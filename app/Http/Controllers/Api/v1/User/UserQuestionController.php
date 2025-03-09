<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\QuestionResource;
use App\Models\Question;
use App\ModelServices\Service\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserQuestionController extends AuthUserController
{
    protected string $resource = QuestionResource::class;
    protected ?string $ownerRelation = "service";

    public function __construct(
        private QuestionService $questionService,
    )
    {
    }

    public function index(): JsonResponse
    {
        $questions = $this->questionService->getServicesQuestions($this->authUser(), ["user", "item"]);
        return $this->ok($this->paginate($questions));
    }

    public function show(Question $question): JsonResponse
    {
        $question->load("user", "service", "item");
        return $this->ok($question);
    }

    public function answer(Request $request, Question $question): JsonResponse
    {
        $data = $request->validate([
            "answer" => "required"
        ]);
        $question->update($data);
        return $this->ok($question);
    }
}
