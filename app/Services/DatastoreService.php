<?php

namespace App\Services;

use Google\Cloud\Datastore\DatastoreClient;

class DatastoreService
{
    private $dataStoreClient;

    public function __construct()
    {
        $this->dataStoreClient = new DatastoreClient([
            'projectId' => getenv('GOOGLE_PROJECT_ID'),
        ]);
    }

    public function insertMessage($key, $postData, $messageId): array
    {
        $datetime = new \DateTime('now', new \DateTimeZone('Asia/Taipei'));
        $message = $this->dataStoreClient->entity($key, [
            'Message' => $postData,
            'OrderNumber' => $postData['order_no'],
            'Status' => $postData['status'],
            'DateTime' => $datetime
        ]);
        $entityVersion = $this->dataStoreClient->insert($message);

        // response訊息回傳
        $data = ['return_code' => 0, 'message' => ''];

        if (empty($messageId) || $messageId < 0) {
            $data['return_code'] = 1;
            $data['message'] = 'queued error';
        }

        if (empty($entityVersion)) {
            $data['return_code'] = 2;
            $data['message'] = 'datastore error';
        }

        return $data;
    }
}
