<?php
namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\Area\Services\AreaService;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Domain\MasterDataManagement\Area\Enums\Area;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;

class AreaSeeder extends Seeder
{

    /*
     * @var AreaRepositoryInterface
     */
    private $area;

    private $areaRepository;

    /**
     * AreaSeeder constructor.
     *
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->areaRepository = app()->make(AreaRepositoryInterface::class);
        $this->area = app()->make(AreaService::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->areaRepository->getModel()->count() == 0) {

            $areas = Area::getInstances();

            foreach ($areas as $area) {

                $this->area->create($area->value);
            }
        }
    }
}
