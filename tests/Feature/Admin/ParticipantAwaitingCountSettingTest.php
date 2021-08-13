<?php

namespace Tests\Feature\Admin;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AwaitingCountType;
use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\ModelDao\ParticipantAwaitingCountSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ParticipantAwaitingCountSettingTest extends TestCase
{
    use RefreshDatabase;

    private $datingDay;

    public function setUp(): void
    {
        parent::setUp();
        $this->authenticateAsAdmin();
        $this->datingDay = DatingDay::factory()->create([
            'dating_day' => 'Wednesday',
            'dating_date' => '2021-05-19'
        ]);

        ParticipantAwaitingCountSetting::factory()->create(
            [
                'prefecture_id' => 1,
                'dating_day_id' => $this->datingDay->id,
                'count' => 101,
                'type' => AwaitingCountType::AwaitingYoung,
                'gender' => 1
            ]
        );

        ParticipantAwaitingCountSetting::factory()->create(
            [
                'prefecture_id' => 1,
                'dating_day_id' => $this->datingDay->id,
                'count' => 11,
                'type' => AwaitingCountType::ApprovedAfter24hMiddle,
                'gender' => 1
            ]
        );
    }

    private function authenticateAsAdmin()
    {
        $admin = Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@xvolve.com',
            'password' => 'password_value',
            'status' => 1
        ]);
        Passport::actingAs($admin, [], 'admin');
    }

    public function test_get_awaiting_count_setting()
    {
        /** @var ParticipantAwaitingCountSetting $setting */
        $response = $this->json('GET', '/admin/gender-ratio', [
            'prefecture_id' => 1,
            'dating_date' => $this->datingDay->dating_date,
            'gender' => 1
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            "message" => "Successful",
            "data" => [
                "count" => [],
                "settings" => [
                    "prefecture_id" => 1,
                    "dating_day_id" => $this->datingDay->id,
                    "gender" => 1,
                    "settings" => [
                        "awaiting_young" => 101,
                        "awaiting_middle" => 0,
                        "awaiting_old" => 0,
                        "approved_before_24h_young" => 0,
                        "approved_before_24h_middle" => 0,
                        "approved_before_24h_old" => 0,
                        "approved_after_24h_young" => 0,
                        "approved_after_24h_middle" => 11,
                        "approved_after_24h_old" => 0
                    ]
                ]
            ]
        ]);
    }

    public function test_update_awaiting_count_setting()
    {
        /** @var ParticipantAwaitingCountSetting $setting */

        $response = $this->json('POST', '/admin/gender-ratio/update', [
            'prefecture_id' => 1,
            'dating_date' => $this->datingDay->dating_date,
            'gender' => 1,
            'settings' => [
                AwaitingCountType::ApprovedAfter24hMiddle => 12
            ]
        ]);

        $response->assertStatus(200);

        $response = $this->json('GET', '/admin/gender-ratio', [
            'prefecture_id' => 1,
            'dating_date' => $this->datingDay->dating_date,
            'gender' => 1
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            "message" => "Successful",
            "data" => [
                "count" => [],
                "settings" => [
                    "prefecture_id" => 1,
                    "dating_day_id" => $this->datingDay->id,
                    "gender" => 1,
                    "settings" => [
                        "awaiting_young" => 101,
                        "awaiting_middle" => 0,
                        "awaiting_old" => 0,
                        "approved_before_24h_young" => 0,
                        "approved_before_24h_middle" => 0,
                        "approved_before_24h_old" => 0,
                        "approved_after_24h_young" => 0,
                        "approved_after_24h_middle" => 12,
                        "approved_after_24h_old" => 0
                    ]
                ]
            ]
        ]);
    }
}
