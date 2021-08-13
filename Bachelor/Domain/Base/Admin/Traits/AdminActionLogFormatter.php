<?php

namespace Bachelor\Domain\Base\Admin\Traits;

use Illuminate\Support\Str;

trait AdminActionLogFormatter
{
    /**
     * User Action Log formatter
     *
     * @param array $context
     * @return array
     */
    public function adminActionLogFormatter(array $context) : array
    {
        return [
            'batch_id' => (string) Str::orderedUuid(),
            'target_id' => $context['targetId'] ?? null,
            'target_name' => $context['targetName'] ?? '',
            'actionable_id' => $context['actionableId'] ?? null,
            'actionable_type' => $context['actionableType'] ?? '',
            'model_id' => $context['modelId'] ?? null,
            'model_type' => $context['modelType'] ?? '',
            'event_name' => $context['targetId'] ?? '',
            'event_domain' => $context['eventDomain'] ?? '',
            'event_type' => $context['eventType'] ?? '',
            'method' => $context['method'] ?? '',
            'data' => $context['data'] ?? '',
            'status' => $context['status'] ?? '',
            'exception' => $context['exception'] ?? '',
            'original' => $context['original'] ?? '',
            'changes' => $context['changes'] ?? '',
        ];
    }
}
