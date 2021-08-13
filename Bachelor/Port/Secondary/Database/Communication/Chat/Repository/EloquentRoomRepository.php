<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Repository;


use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Room;
use Illuminate\Support\Facades\DB;

class EloquentRoomRepository extends EloquentBaseRepository implements EloquentRoomInterface
{
    /**
     * EloquentRoomRepository constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    /**
     * @param array $params
     * @return mixed|void
     */
    public function createRoom(array $params)
    {
        $this->model->create([
            'id' => $params['room_id'],
            'name' => $params['name'],
            'type' => $params['type'],
            'created_by' => $params['created_by'],
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);

        return $this->model->where('id', $params['room_id'])->first();
    }

    /**
     * @param string $keyword
     * @param array $roomIds
     * @param null $perPage
     * @return mixed
     */
    public function getRooms($keyword = '', $roomIds = [], $perPage = null)
    {
        $query = $this->model->where('id', $keyword)
            ->orWhereIn('id', $roomIds);
        if ($keyword) {
            $query->orderByRaw(DB::raw("FIELD(id, '$keyword') desc"));
        }
        $perPage = $perPage ? $perPage : $this->modelDAO->getPerPage();

        return $query->with('users')
            ->with('messages.user')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * @param integer $id
     * @return array
     */
    public function getDaoBy(string $id): Room
    {
        return $this->model->with('roomUsers')->find($id);
    }
}
