<?php

namespace App\Enums;

enum TransactionType: string
{
    case Withdraw = "Withdraw";
    case Deposit = "Deposit";
    case Transfer = "Transfer";
}
