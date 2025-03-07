<?php

namespace App\ModelServices\User;

use App\Enums\BanRule;
use App\Events\UserWasBanned;
use App\Exceptions\ModelException;
use App\Models\Ban;
use App\Models\User;
use App\Utils\EnumHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BanService
{
    public function getAll(): Builder
    {
        return Ban::query();
    }

    public function banUser(User $admin, User $user, array $data): Ban
    {
        if ($this->isBanned($user)) {
            throw new ModelException("user can not be banned");
        }
        $data['started_at'] = $data["started_at"] ?? now();
        $data["duration"] = $this->calculateDuration($user, $data["reason"], $data["duration"] ?? null);
        $data["user_id"] = $user->id;
        $banned = $admin->bannedUsers()->create($data);
        UserWasBanned::dispatch($banned);
        return $banned;
    }

    public function activeBanned(): Builder
    {
        return Ban::active();
    }

    public function isBanned(User $user): bool
    {
        return $user->banHistory()->active()->exists();
    }

    public function unBan(User $user): Ban
    {
        $lastBanned = $this->lastBans($user)->first();
        if (!$lastBanned) {
            throw new ModelException("user has not been banned");
        }
        $this->finishBan($lastBanned);
        return $lastBanned;
    }

    public function finishBan(Ban $ban): void
    {
        $ban->update(['finished' => true]);
    }

    public function lastBans(User $user, ?string $reason = null): HasMany
    {
        $query = $user->banHistory()->finished();
        if ($reason) {
            $query = $query->where('reason', $reason);
        }
        return $query->latest();
    }

    private function calculateDuration(User $user, string $reason, ?int $duration = null): int
    {
        if ($duration) {
            return $duration;
        }
        $lastBan = $this->lastBans($user, $reason)->first();
        $duration = EnumHelper::getValue(BanRule::class, $reason) ?? 1;
        if (!$lastBan) {
            return $duration;
        }
        return $lastBan->duration * 2;
    }
}
