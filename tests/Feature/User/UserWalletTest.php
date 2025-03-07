<?php

namespace Tests\Feature\User;

use Illuminate\Support\Facades\Hash;
use Tests\UserTest;

class UserWalletTest extends UserTest
{
    public function test_index_should_update_wallet_password()
    {
        $password = "123456";
        $this->withoutExceptionHandling();
        $this->postJson(route('v1.user.wallet.update-password'), [
            "password" => $password
        ]);
        $walletPassword = $this->user->wallet->password;
        $this->assertNotNull($walletPassword);
        $this->assertTrue(Hash::check($password, $walletPassword));
    }
}
