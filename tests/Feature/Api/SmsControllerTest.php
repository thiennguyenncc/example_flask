<?php


namespace Tests\Feature\Api;



use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SmsControllerTest extends TestCase
{

    /**
     * S_01_05 I must enter 4-digit code to verify phone number
     */
    public function test_verify_code()
    {
        $mobileNumber = '0123456';
        $verificationCode = rand(1000, 9999);
        Cache::remember($mobileNumber, 3600, function() use ($verificationCode){
            return $verificationCode;
        });

        $response = $this->json('POST', '/api/v2/verify-code', [
            'mobileNumber' => $mobileNumber,
            'country' => 'Japan',
            'verificationCode' => $verificationCode
        ]);
        $response->assertStatus(200);

        $response->assertSee([
            "message" => "Mobile Number 0123456 is successfully verified"
        ]);
    }

    /**
     * S_01_06 I cannot verify phone number with wrong code
     */
    public function test_verify_unknown_code()
    {
        $mobileNumber = '0123456';

        $response = $this->json('POST', '/api/v2/verify-code', [
            'mobileNumber' => $mobileNumber,
            'country' => 'Japan',
            'verificationCode' => rand(1000, 9999)
        ]);

        $response->assertStatus(513);

        $response->assertSee([
            "message" => "\u6709\u52b9\u306a\u78ba\u8a8d\u30b3\u30fc\u30c9\u3067\u306f\u3042\u308a\u307e\u305b\u3093"
        ]);
    }


}
