<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * 自定錯誤頁
     * @param string $errCode 錯誤代碼
     * @param string $errMsg 錯誤訊息
     * @param string $url 導向下一頁
     */
    public function customError($errCode = '500', $errMsg = '不明的錯誤', $url = '')
    {
        return response()->json(['errMsg' => $errMsg], $errCode);
        return response()->view('errors.custom', [
            'statusCode' => $errCode,
            'errMsg' => $errMsg,
            'url' => $url
        ]);
    }
}
