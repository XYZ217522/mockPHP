# App Engine V2

### 前言
- 由於官方建議v2版本需要將PHP 應用程式選擇一種framework來開發，此project選擇 [Laravel](https://laravel.com/)並且使用docker來開發
- 需要在本地安裝gcloud cli
- 有用到GCP服務：```App Engine``` , ```Pub/Sub```, ```DataStore```
### 步驟
- git clone project 到本地
- 建立docker-compose.yml，要填入```ports```,```GOOGLE_APPLICATION_CREDENTIALS```(要跟GCP管理者申請，從IAM下載)
- 將container啟動後，並進入container。安裝composer後，再使用composer安裝Laravel
- 要在docker中使用GCP的服務，要在docker-compose填入```GOOGLE_APPLICATION_CREDENTIALS```，GCP的libs會去抓此環境變數
- 上述步驟準備完成就可以在/routes/api.php撰寫api
- 啟動web server 輸入指令 ``` php artisan serve --host=0.0.0.0 --port=8000 ```，啟動後就可以使用postman測試
- 可以在```GCP```查看pub/sub有無收到訊息，Datastore是否有新增資料

### App Engine deploy
- 在project跟目錄下，輸入指令
  ```gcloud app deploy app_dev.yaml --version 1```
  version 是可選的
### App Engine deploy issues
- 由於app engine 存取檔案只能在/tmp目錄之下，所以需要在app.yaml定義好環境變數
```
env_variables:
  LOG_CHANNEL: stderr
  APP_STORAGE: /tmp/storage
  APP_STORAGE_PATH: /tmp
  VIEW_COMPILED_PATH: /tmp
  SESSION_DRIVER: cookie
```
- 部署完後若遇到一些exception，需要調整composer.php，可參考
```
composer remove --dev facade/ignition
moving "nunomaduro/collision": "^2.0" from "require-dev" to "require”
```
另外composer.php 裡面的script也一並調整，可參考
Exception: The /workspace/bootstrap/cache directory must be present and writable
[link](https://github.com/GoogleCloudPlatform/php-docs-samples/issues/1167)

