<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isJson;

class EncryptionController extends Controller
{

    const ENCRYPT_SHELL = "encryption_helper";

    public function encrypt(Request $request): JsonResponse
    {
        $requestText = $request->get('text');
        if (empty($requestText) || empty($key = $_SERVER['ENCRYPTION_KEY'])) {
            return new JsonResponse(['return_code' => 9999, 'message' => 'content empty']);
        }

        $cmd = sprintf("cd /golang && ENCRYPTION_KEY=%s ./%s encrypt %s",
            $key,
            self::ENCRYPT_SHELL,
            $requestText
        );

        $output = shell_exec($cmd);
        if (!isJson($output)) {
            return new JsonResponse(['return_code' => 9998, 'message' => $output]);
        }

        return response()->json(json_decode($output));
    }

    public function decrypt(Request $request): JsonResponse
    {
        $requestText = $request->get('text');
        if (empty($requestText) || empty($key = $_SERVER['ENCRYPTION_KEY'])) {
            return new JsonResponse(['return_code' => 9999, 'message' => 'content empty']);
        }
        $cmd = sprintf("cd /golang && ENCRYPTION_KEY=%s ./%s decrypt %s",
            $key,
            self::ENCRYPT_SHELL,
            $requestText
        );

        $output = shell_exec($cmd);
        if (!isJson($output)) {
            return new JsonResponse(['return_code' => 9998, 'message' => $output]);
        }

        return response()->json(json_decode($output));
    }
}
