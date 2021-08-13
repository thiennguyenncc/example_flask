<?php
namespace Bachelor\Port\Secondary\UserManagement\Kickbox\Repository;

use Bachelor\Domain\UserManagement\User\Interfaces\SendableEmailRepositoryInterface;
use Bachelor\Port\Secondary\UserManagement\Kickbox\Base\KickboxBaseRepository;
use Bachelor\Utility\Helpers\Log;

class KickboxSendableEmail extends KickboxBaseRepository implements SendableEmailRepositoryInterface
{

    /**
     * @param $email
     * @return bool
     * @throws \ErrorException
     */
    public function verifyEmail($email): bool
    {
        if(!env('KICKBOX_API_KEY')){
            if(env('APP_ENV') == 'production') {
                Log::error('kixkbox api key doesnt exist');
            }
            return true;
        }else{
            $kickBox = $this->client->kickbox();
            $response = $kickBox->verify($email);
            return $response->body['result'] === 'deliverable';
        }
    }

}
