<?php

namespace Bachelor\Port\Secondary\Database\NotificationManagement\Notification\ModelDao;

use Bachelor\Domain\NotificationManagement\Notification\Models\Notification as NotificationDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends BaseModel
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'notifications';

    protected $hidden = [];

    /**
     * @return NotificationDomainModel
     */
    public function toDomainEntity ()
    {
        $model = new NotificationDomainModel(
            $this->key,
            $this->type,
            $this->title,
            $this->content,
            $this->status,
            $this->variables ? explode(',', $this->variables) : [],
            $this->label,
            $this->eligible_user_key,
            $this->prefectures ? explode(',', $this->prefectures) : [],
            $this->follow_interval
        );
        $model->setId($this->getKey());
        $model->setUpdatedAt($this->updated_at);
        $model->setCreatedAt($this->created_at);

        return $model;
    }

    /**
     * @param NotificationDomainModel $model
     * @return Notification
     */
    protected function fromDomainEntity($model)
    {
        $this->key = $model->getKey();
        $this->type = $model->getType();
        $this->title = $model->getTitle();
        $this->content = $model->getContent();
        $this->status = $model->getStatus();
        $this->variables = count($model->getVariables()) ? implode(',', $model->getVariables()) : null;
        $this->label = $model->getLabel();
        $this->eligible_user_key = $model->getEligibleUserKey();
        $this->prefectures = count($model->getPrefectureIds()) ? implode(',', $model->getPrefectureIds()) : null;
        $this->follow_interval = $model->getFollowInterval();

        return $this;
    }
}
