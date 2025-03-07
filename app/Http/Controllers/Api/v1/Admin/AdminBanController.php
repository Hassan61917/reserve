<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminBanRequest;
use App\Http\Resources\v1\BanResource;
use App\Models\Ban;
use App\Models\User;
use App\ModelServices\User\BanService;
use Illuminate\Http\JsonResponse;

class AdminBanController extends Controller
{
    protected string $resource = BanResource::class;

    public function __construct(
        private BanService $banService
    )
    {
    }

    public function index(): JsonResponse
    {
        $bans = $this->banService->getAll();
        return $this->ok($this->paginate($bans));
    }

    public function ban(User $user, AdminBanRequest $request): JsonResponse
    {
        if ($this->authUser()->is($user) || $user->hasRole("admin")) {
            return $this->error(403, "the user can not be banned");
        }
        $data = $request->validated();
        $ban = $this->banService->banUser($this->authUser(),$user, $data);
        return $this->ok($ban);
    }

    public function unban(User $user): JsonResponse
    {
        if ($this->authUser()->is($user)) {
            return $this->error(403, "the user can not be unbanned");
        }
        $this->banService->unBan($user);
        return $this->ok($user);
    }

    public function show(Ban $ban): JsonResponse
    {
        return $this->ok($ban);
    }

    public function update(AdminBanRequest $request, Ban $ban): JsonResponse
    {
        $data = $request->validated();
        $ban->update($data);
        return $this->ok($ban);
    }

    public function destroy(Ban $ban): JsonResponse
    {
        $ban->delete();
        return $this->deleted();
    }
}
