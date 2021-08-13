<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao;

use Bachelor\Port\Secondary\Database\Base\BaseModel;

class MatchingDateSetting extends BaseModel
{

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at' ,
        'updated_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matching_date_settings';

    public function toDomainEntity()
    {

    }

    protected function fromDomainEntity($user)
    {

    }
}
