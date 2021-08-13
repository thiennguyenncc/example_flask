<?php

namespace Bachelor\Application\Admin\Traits;

trait ParticipantListFormatter
{
    /**
     * @param array $data
     * @return array
     */
    private function formatList(array $data)
    {
        $formattedList = [];
        //group list by user id
        foreach ($data['data'] as $participant) {
            $formattedList[$participant['user_id']]['user_id'] = $participant['user_id'];
            $formattedList[$participant['user_id']]['dating_dates'][] = $participant['dating_date'];
        }
        $data['data'] = array_values($formattedList);

        return $data;
    }
}
