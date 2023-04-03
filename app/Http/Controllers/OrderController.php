<?php

namespace App\Http\Controllers;

use App\Services\DatastoreService;
use App\Services\PubSubReceiverService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    private $pubSubReceiverService;
    private $datastoreService;

    public function __construct(PubSubReceiverService $pubSubReceiverService, DatastoreService $datastoreService)
    {
        $this->pubSubReceiverService = $pubSubReceiverService;
        $this->datastoreService = $datastoreService;
    }

    public function updateOrder(Request $request, $orderNumber = 0): JsonResponse
    {
        if (preg_match('/[^0-9]+/i', $orderNumber)) {
            return new JsonResponse(['return_code' => 10004, 'message' => 'order no in path must be an integer']);
        }

        if (!empty($order = $request->getContent())) {
//            $result = Check::checkEsMarketFieldFormat($order);
//            if ($result['code'] != 0) {
//                return new JsonResponse(['return_code' => $result['code'], 'message' => $result['message']]);
//            }
            $postData = json_decode($order, true);
        }

        if (empty($postData)) {
            return new JsonResponse(['return_code' => 10003, 'message' => 'content empty']);
        }

        $postData['primary_id'] = (int)$orderNumber;
        $publishData['status'] = 'UPDATE';

        $publishResponse = $this->pubSubReceiverService->publishData(['data' => json_encode($publishData)]);

        $messageIds = $publishResponse['messageIds'] ?? [];
        $messageId = $messageIds[0] ?? 0;

        $datastoreResponse = $this->datastoreService->insertMessage('orders', $postData, $messageId);
        return new JsonResponse($datastoreResponse);
    }

    public function addOrder(Request $request): JsonResponse
    {
        if (!empty($order = $request->getContent())) {
//            $result = Check::checkEsMarketFieldFormat($order);
//            if ($result['code'] != 0) {
//                return new JsonResponse(['return_code' => $result['code'], 'message' => $result['message']]);
//            }
            $postData = json_decode($order, true);
        }

        if (empty($postData)) {
            return new JsonResponse(['return_code' => 10003, 'message' => 'content empty']);
        }

        $publishData['status'] = 'NEW';
        $publishResponse = $this->pubSubReceiverService->publishData(['data' => json_encode($publishData)]);

        $messageIds = $publishResponse['messageIds'] ?? [];
        $messageId = $messageIds[0] ?? 0;

        $datastoreResponse = $this->datastoreService->insertMessage('orders', $postData, $messageId);
        return new JsonResponse($datastoreResponse);
    }
}
