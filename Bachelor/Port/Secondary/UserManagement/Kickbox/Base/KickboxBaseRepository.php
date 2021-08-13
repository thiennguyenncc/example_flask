<?php
namespace Bachelor\Port\Secondary\UserManagement\Kickbox\Base;


use Kickbox\Client;

class KickboxBaseRepository
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * KickboxBaseRepository constructor.
     */
    public function __construct ()
    {
        $this->client = new Client(env('KICKBOX_API_KEY'));
    }
}

