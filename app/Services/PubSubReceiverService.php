<?php

namespace App\Services;

use Google\Cloud\PubSub\PubSubClient;

class PubSubReceiverService
{
    private $projectId;
    private $topicName;

    public function __construct()
    {
        $this->projectId = getenv('GOOGLE_PROJECT_ID');
        $this->topicName = getenv('GOOGLE_PUBSUB_TOPIC');
    }

    public function publishData(array $array): array
    {
        $pubSub = new PubSubClient(['projectId' => $this->projectId]);
        $topic = $pubSub->topic($this->topicName);
        return $topic->publish($array);
    }
}
