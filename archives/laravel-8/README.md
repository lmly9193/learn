## 套件依賴

| package                   | version  | description                                                                                                         |
| ------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------- |
| barryvdh/laravel-debugbar | v3.6.5   | PHP Debugbar integration for Laravel                                                                                |
| doctrine/dbal             | 3.2.1    | Powerful PHP database abstraction layer (DBAL) with many features for database schema introspection and management. |
| facade/ignition           | 2.17.4   | A beautiful error page for Laravel applications.                                                                    |
| fakerphp/faker            | v1.17.0  | Faker is a PHP library that generates fake data for you.                                                            |
| fruitcake/laravel-cors    | v2.0.5   | Adds CORS (Cross-Origin Resource Sharing) headers support in your Laravel application                               |
| guzzlehttp/guzzle         | 7.4.1    | Guzzle is a PHP HTTP client library                                                                                 |
| laravel/fortify           | v1.8.6   | Backend controllers and scaffolding for Laravel authentication.                                                     |
| laravel/framework         | v8.78.1  | The Laravel Framework.                                                                                              |
| laravel/sail              | v1.12.12 | Docker files for running a basic Laravel application.                                                               |
| laravel/sanctum           | v2.13.0  | Laravel Sanctum provides a featherweight authentication system for SPAs and simple APIs.                            |
| laravel/tinker            | v2.6.3   | Powerful REPL for the Laravel framework.                                                                            |
| livewire/livewire         | v2.8.2   | A front-end framework for Laravel.                                                                                  |
| mockery/mockery           | 1.4.4    | Mockery is a simple yet flexible PHP mock object framework                                                          |
| nunomaduro/collision      | v5.10.0  | Cli error handling for console/command-line PHP applications.                                                       |
| phpunit/phpunit           | 9.5.11   | The PHP Unit Testing framework.                                                                                     |

```bash
composer show -D
```

## 安裝

1. 安裝 composer 套件

```bash
composer install
```

2. 產生金鑰

```bash
php artisan key:generate
```

3. 資料庫遷移

```bash
php artisan migrate
php artisan migrate --seed (如果有seed)
```

4. 儲存路徑軟連接

```bash
php artisan storage:link
```

5. 安裝 npm 套件

```bash
npm install
```

6. Laravel Mix

```bash
npm run dev
npm run development
npm run watch
npm run hot
npm run prod
npm run production
```

## 管理員設定

```bash
php artisan db:seed --class=AdminSeeder
```

## 常用網站

[全部書籤](https://github.com/lmly9193/lmly9193/blob/main/bookmarks.md)

| 網站                                                                 | 說明                                                             |
| -------------------------------------------------------------------- | ---------------------------------------------------------------- |
| [Laravel 速查表](https://learnku.com/docs/laravel-cheatsheet)        | 來自 Learnku 社群所提供                                          |
| [Laravel 中文文檔](https://learnku.com/docs/laravel/)                | 來自 Learnku 社群所提供                                          |
| [PHP 文件](https://www.php.net/manual/zh/)                           | PHP 官方文件                                                     |
| [PHP 函數速查表](https://www.p2hp.com/phpfuncs.html)                 | PHP 中文站提供的函數速查表                                       |
| [PHP Sandbox](https://sandbox.onlinephpfunctions.com/)               | 來自 Online PHP Functions 的 PHP 測試沙盒，支援非常多 PHP 版本。 |
| [Bootstrap 5 繁體中文文件](https://bootstrap5.hexschool.com/)        | 六角學院譯                                                       |
| [W3Schools](https://www.w3schools.com/)                              | W3Schools 是於 1999 年創立的一個網站開發教程門戶                 |
| [w3big.com](http://www.w3big.com/zh-TW/)                             | 最完整的線上網頁技術教學網站、全中文教學、自學網頁               |
| [jQuery API 3.5.1 速查表](https://jquery.cuishifeng.cn/)             | 作者 Shifone                                                     |
| [SQL 語法教學](https://www.1keydata.com/tw/sql/sql-sitemap.html)     | 這個 SQL 教材網站列出常用的 SQL 指令。                           |
| [jsDelivr](https://www.jsdelivr.com)                                 | A free CDN for Open Source. fast, reliable, and automated.       |
| [Webhook.site](https://webhook.site)                                 | 輕鬆檢查、測試和自動化任何傳入的 HTTP 請求或電子郵件             |
| [Mailtrap](https://mailtrap.io/)                                     | Email Sandbox Service                                            |
| [RegExr 中文](https://regexr-cn.com/)                                | 正規表示式測試                                                   |
| [Mockaroo](https://mockaroo.com/)                                    | 隨機資料產生                                                     |
| [Table Convert Online](https://tableconvert.com/)                    | 表格資料轉換成各種格式                                           |
| [SQLizer](https://sqlizer.io)                                        | 各種資料格式轉換成 SQL                                           |
| [JSON Editor Online](https://jsoneditoronline.org/)                  | 視覺化的 JSON 格式線上編輯器                                     |
| [URL Decoder/Encoder](https://meyerweb.com/eric/tools/dencoder/)     | 網址字串加解密                                                   |
| [Unicode 字元轉換](https://www.ifreesite.com/unicode-ascii-ansi.htm) | Unicode 編碼轉換                                                 |
| [Base64 decode](https://www.base64decode.net/)                       | Base64 線上加解密                                                |
| [Base64 Image Encoder](https://www.base64-image.de/)                 | 線上圖片轉 Base64                                                |
