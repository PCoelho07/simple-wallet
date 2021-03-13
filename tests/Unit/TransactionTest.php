<?php

namespace Tests\Unit;

use App\Jobs\TransferReceivedNotification;
use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make a successfull transfer
     *
     * @return void
     */
    public function testMakeSuccessfullTransfer()
    {
        Bus::fake();

        $response = $this->transactionPostRequest($this->commonUser);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "success" => true,
            ]);

        $data = $response->decodeResponseJson('data');

        $this->assertDatabaseHas('transactions', $data);

        Bus::assertDispatched(TransferReceivedNotification::class, function ($job) use ($data) {
            return $job->user->id === $data['user_source_id'];
        });
    }

    /**
     * Make transfer without a auth token
     *
     * @return void
     */
    public function testMakeTransferUnauthenticated()
    {
        $response = $this->transactionPostRequest();

        $response
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated."
            ]);
    }

    /**
     * Make transfer without a common user role
     *
     * @return void
     */
    public function testMakeTransferWhithoutPermission()
    {
        $response = $this->transactionPostRequest($this->shopkeeper);

        $response
            ->assertStatus(403)
            ->assertJsonFragment([
                "message" => "This action is unauthorized."
            ]);
    }

    /**
     * Make transfer when source user does not have money
     *
     * @return void
     */
    public function testMakeTransferInsufficientMoney()
    {
        $response = $this->transactionPostRequest($this->commonUser, 200.00);

        $response
            ->assertStatus(400)
            ->assertJsonFragment([
                "success" => false,
                "error" => "Can not store the resource!"
            ]);
    }

    /**
     * Make transfer when user does not exist
     *
     * @return void
     */
    public function testMakeTransferUsersNotFound()
    {
        $data = [
            "value" => 10.00,
            "payer" => 10,
            "payee" => 12,
        ];

        $response = $this->transactionPostRequest($this->commonUser, null, $data);

        $response
            ->assertStatus(400)
            ->assertJsonFragment([
                "success" => false,
                "error" => "Can not store the resource!"
            ]);
    }

    /**
     * Make transfer when user does not exist
     *
     * @return void
     */
    public function testMakeTransferAuthorizerFalse()
    {
        $this->app->instance(AuthorizerInterface::class, Mockery::mock(AuthorizerInterface::class, function ($mock) {
            $mock->shouldReceive('authorize')
                ->once()
                ->andReturn(false);
        }));

        $response = $this->transactionPostRequest($this->commonUser);

        $response
            ->assertStatus(400)
            ->assertJsonFragment([
                "success" => false,
                "error" => "Can not store the resource!"
            ]);
    }

    /**
     * Make a transaction post
     * @param User|null $actingAs
     * @param float|null $value
     * @return \Illuminate\Foundation\Testing\TestResponse $response
     */
    private function transactionPostRequest($actingAs = null, $value = null, $data = null)
    {

        $data = $data ?? [
            "value" => $value ?? 10.00,
            "payer" => $this->commonUser->id,
            "payee" => $this->shopkeeper->id,
        ];

        if (!is_null($actingAs)) {
            $response = $this->actingAs($actingAs, 'api')
                ->postJson('/api/transactions', $data);

            return $response;
        }

        $response = $this->postJson('/api/transactions', $data);

        return $response;
    }
}
