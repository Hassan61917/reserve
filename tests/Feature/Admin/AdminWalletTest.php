<?php

namespace Admin;

use Tests\AdminTest;

class AdminWalletTest extends AdminTest
{
    public function test_deposit_should_deposit_amount_to_user_wallet()
    {
        $user = $this->makeUser("user");
        $balance = $user->wallet->balance;
        $amount = 100;
        $this->postJson(route("v1.admin.wallets.deposit", $user->wallet), ["amount" => $amount]);
        $this->assertDatabaseCount("wallet_transactions", 1);
        $this->assertEquals($amount, $balance + $amount);
    }

    public function test_deposit_should_not_deposit_if_user_is_same()
    {
        $user = $this->user;
        $balance = $user->wallet->balance;
        $amount = 100;
        $this->postJson(route("v1.admin.wallets.deposit", $user->wallet), ["amount" => $amount])
                ->assertStatus(403);
        $this->assertDatabaseCount("wallet_transactions", 0);
        $this->assertNotEquals($amount, $balance + $balance);
    }
    public function test_deposit_should_withdraw_amount_to_user_wallet()
    {
        $user = $this->makeUser("user");
        $amount = 50;
        $this->postJson(route("v1.admin.wallets.deposit", $user->wallet), ["amount" => $amount]);
        $this->postJson(route("v1.admin.wallets.withdraw", $user->wallet), ["amount" => $amount - 10]);
        $this->assertEquals(10, $user->fresh()->wallet->balance);
    }
    public function test_deposit_should_transfer_amount_to_user_wallet()
    {
        $user1 = $this->makeUser("user");
        $user2 = $this->makeUser("user");
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.admin.wallets.deposit", $user1->wallet), ["amount" => 100]);
        $this->postJson(route("v1.admin.wallets.transfer", [$user1->wallet,$user2->wallet]), ["amount" => 50]);
        $this->assertDatabaseCount("wallet_transactions", 2);
        $this->assertEquals(50, $user1->fresh()->wallet->balance);
        $this->assertEquals(50, $user2->fresh()->wallet->balance);
    }
}

