<?php

namespace Bachelor\Domain\DatingManagement\RequestCancellationForm\Services;

use Bachelor\Port\Secondary\Database\DatingManagement\RequestCancellationForm\Interfaces\EloquentRequestCancellationFormInterface;
use Bachelor\Port\Secondary\Database\DatingManagement\RequestCancellationForm\ModelDao\RequestCancellationForm;
use Illuminate\Database\Eloquent\Model;

class RequestCancellationFormRepository
{
    /**
     * @var EloquentRequestCancellationFormInterface
     */
    private $requestCancellationFormRepository;

    /**
     * DatingRepository constructor.
     * @param EloquentRequestCancellationFormInterface $requestCancellationFormRepository
     */
    public function __construct(EloquentRequestCancellationFormInterface $requestCancellationFormRepository)
    {
        $this->requestCancellationForm = $requestCancellationFormRepository;
    }

    /**
     * regist form fields
     *
     * @param integer $datingId
     * @return Model
     */
    public function registForm($user,string $datingId,Array $fields): bool
    {
         return $this->requestCancellationForm->registForm($user,$datingId, $fields);
    }
}
