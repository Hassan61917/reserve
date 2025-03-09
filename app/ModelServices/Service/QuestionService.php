<?php

namespace App\ModelServices\Service;

use App\Events\QuestionWasAsked;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionService
{
    public function getAll(array $relations = []): Builder
    {
        return Question::query()->with($relations);
    }

    public function getQuestionsFor(User $user, array $relations = []): HasMany
    {
        return $user->questions()->with($relations);
    }

    public function getServicesQuestions(User $user, array $relations = []): Builder
    {
        return Question::query()
            ->join('services', 'questions.service_id', '=', 'services.id')
            ->where("services.user_id", $user->id)
            ->with($relations);
    }

    public function makeQuestion(User $user, array $data): Question
    {
        $question = $user->questions()->create($data);
        QuestionWasAsked::dispatch($question);
        return $question;
    }
}
