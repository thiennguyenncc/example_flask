<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\Repository;

use Bachelor\Domain\MasterDataManagement\RegisterOption\Enums\RegistrationOptionCustomDisplayText;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOption;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOptionTranslation;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Illuminate\Support\Collection;

class EloquentRegisterOptionRepository extends EloquentBaseRepository implements EloquentRegisterOptionInterface
{
    /**
     * EloquentRegisterOptionRepository constructor.
     * @param RegisterOption $model
     */
    public function __construct(RegisterOption $model)
    {
        parent::__construct($model);
    }

    /**
     * get register option display name
     *
     * @param mixed $optionValue
     * @param string $type
     * @param integer|null $gender
     * @return string
     */
    public function getRegisterOptionDisplayName(mixed $optionValue, string $type, ?int $gender = null) :string
    {
        if(is_null($optionValue)){
            return "";
        }
        
        $registerOption = $this->createQuery()
            ->where('option_value',$optionValue)
            ->where('type',$type);

        if($gender){
            $registerOption = $registerOption->where(function($query) use ($gender) {
                $query->where('allowed_gender',$gender)->orWhereNull('allowed_gender');
            });
        }
        return $registerOption->first()?->registerOptionsTranslations()->first()?->display_name ?? "";
    }

    /**
     * get register option display name by array
     *
     * @param array $optionValues
     * @param string $type
     * @param integer|null $gender
     * @return string
     */
    public function getRegisterOptionDisplayNames(array $optionValues, string $type, ?int $gender = null) :array
    {
        foreach($optionValues as &$optionValue) {
            $optionValue = $this->getRegisterOptionDisplayName($optionValue,$type,$gender);
        }
        return $optionValues;
    }

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function createRegisterOptionTranslation(RegisterOption $model, array $data)
    {
        return $model->registerOptionsTranslations()->create($data);
    }

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function firstOrCreateRegisterOptionTranslation(RegisterOption $model, array $data)
    {
        return $model->registerOptionsTranslations()->firstOrCreate($data);
    }

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function firstOrNewRegisterOptionTranslation(RegisterOption $model, array $data)
    {
        return $model->registerOptionsTranslations()->firstOrNew($data);
    }

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function updateOrCreateRegisterOptionTranslation(RegisterOption $model, array $data)
    {
        return $model->registerOptionsTranslations()->updateOrCreate($data);
    }

    /**
     * Create new register option translation
     *
     * @param RegisterOptionTranslation $model
     * @param array $fill
     * @return
     */
    public function replicateRegisterOptionTranslation(RegisterOptionTranslation $model, array $fill)
    {
        return $model->registerOptionsTranslations()->replicate()->fill($fill);
    }

    /**
     * @param string $type
     * @param int $gender
     * @return Collection
     */
    public function getRegistrationOptionByType($type, int $gender = 0): Collection{
        $query = $this->createQuery();
        $query = $query->where('type', $type);
        if($gender > 0){
            $query = $query->where(function($query) use ($gender) {
                $query->where('allowed_gender',$gender)
                    ->orWhereNull('allowed_gender');
            });
        }
        return $this->transformCollection($query->get());
    }

    /**
     * @param array $types
     * @param int $gender
     * @return Collection
     */
    public function getRegistrationOptionByTypes($optionType, int $gender = 0): Collection{
        $query = $this->createQuery();
        $query = $query->whereIn('type', $optionType);
        if($gender > 0){
            $query = $query->where(function($query) use ($gender) {
                $query->where('allowed_gender',$gender)
                    ->orWhereNull('allowed_gender');
            });
        }
        return $this->transformCollection($query->get());
    }
}
