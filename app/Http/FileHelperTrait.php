<?php

namespace App\Http;

trait FileHelperTrait
{

    /**
     * 從檔案中取出資料
     * @param string $path
     * @param $callback
     * @return array
     */
    public function getDataByFile(string $path, $callback = null): array
    {
        $jsonString = file_get_contents(base_path($path));
        $data = json_decode($jsonString, true);
        if (!empty($data) && ($data['expire_ts'] ?? 0) > time()) {
            unset($data['expire_ts']);
            return $data;
        }

        $dataFromCallback = empty($callback) ? [] : call_user_func($callback);
//        print_r($dataFromCallback);exit;
        if (!empty($dataFromCallback) && is_array($dataFromCallback)) {
            $this->writeDataToFile($path, $dataFromCallback);
            return $dataFromCallback;
        }

        return [];
    }

    /**
     * 將資料寫入到指定的檔案，並新增資料過期時間
     * @param string $path
     * @param array $data
     * @return bool
     */
    public function writeDataToFile(string $path, array $data): bool
    {
        if (empty($data) || empty($path)) {
            return false;
        }

        $data['expire_ts'] = time() + config('cache.fileHelper.gameRecord.expireTs');
        if (empty($newJsonString = json_encode($data))) {
            return false;
        }
        return file_put_contents(base_path($path), $newJsonString);
    }

    public function clearFileCache(string $path) {
        file_put_contents(base_path($path), '');
    }
}
