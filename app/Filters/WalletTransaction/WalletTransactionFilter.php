<?php

namespace App\Filters\WalletTransaction;

use App\Enums\TransactionType;
use App\Filters\ModelFilter;
use App\Utils\EnumHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class WalletTransactionFilter extends ModelFilter
{
    protected string $searchValue = "code";
    protected array $handlers = ["type", "amount"];

    public function amount(Builder $builder, string $value): Builder
    {
        [$operation, $value] = explode(":", $value);
        $operations = ["gt" => ">=", "lt" => "<="];
        return $builder->where('amount', $operations[$operation], $value);
    }

    public function type(Builder $builder, string $type): Builder
    {
        $type = Str::studly($type);
        if (in_array($type, EnumHelper::toArray(TransactionType::class))) {
            return $builder->where('type', $type);
        }
        return $builder;
    }
}
