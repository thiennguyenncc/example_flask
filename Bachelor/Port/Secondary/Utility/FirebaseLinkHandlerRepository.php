<?php

namespace Bachelor\Port\Secondary\Utility;

use Illuminate\Support\Facades\Log;

use Bachelor\Utility\Interfaces\LinkHandlerRepositoryInterface;
use Kreait\Firebase\Contract\DynamicLinks;
use Kreait\Firebase\DynamicLink\CreateDynamicLink\FailedToCreateDynamicLink;

class FirebaseLinkHandlerRepository implements LinkHandlerRepositoryInterface
{
    /**
     * @var DynamicLinks
     */
    private DynamicLinks $dynamicLinks;

    public function __construct()
    {
        $this->dynamicLinks = app('firebase.dynamic_links');
    }

    /*
     * URL shortener
     */
    public function shortenUrl(string $url) : ?string
    {
        try {
            $link = $this->dynamicLinks->createShortLink($url);
            $uriString = (string) $link;
            return $uriString;
        } catch (FailedToCreateDynamicLink $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}