# Laravel-RestAPI
Laravel Restful API management

## Feature
- Improve your API Response data structure

## Installation
```composer require anhzf/laravel-rest-api```

## API Response JSON data structure
```json
{
  "success": true,
  "message": "your message here",
  "data": {
    "myData": "your data here..."
  },
  "errors": [
    "laravel", "automatically", "send", "exceptions", "here..."
  ]
}
```

## Usage

### Add Message | ```APIResponse::message(string $message)```
```php
  use Anhzf\LaravelRestAPI\APIResponse;
  
  // end of some controller
  return APIResponse::message('[your message here]')->send();
```

### Add Data | ```APIResponse::data(array $data) ```
```php
  use Anhzf\LaravelRestAPI\APIResponse;
  
  $myData = ['foo', 'bar', 'baz'];
  // end of some controller
  return APIResponse::data(compact('myData'))->send();
```

### Set HTTP Status Code | ```APIResponse::statusCode(int $statusCode)```
```php
  use Anhzf\LaravelRestAPI\APIResponse;
  
  // end of some controller
  return APIResponse::statusCode(404)
        ->message('Didn\'t find matched user!')
        ->send();
```

### Send Error Response | ```APIResponse::error()```
It will send response without ```success``` key in your Json Response
```php
  use Anhzf\LaravelRestAPI\APIResponse;
  
  // end of some controller
  return APIResponse::error()
      ->statusCode(422)
      ->message('email field is required!')
      ->send();
```

### Send Response Shortcut
By adding ```Send``` verb in above listed method, it will be send response like using ```send()```
```php
  use Anhzf\LaravelRestAPI;
  
  class APIResponse {
    public static sendMessage(string $message);
    public static sendData(array $data);
    public static sendStatusCode(int $statusCode, bool $success = true);
    public static sendError(string $message = null, int $statusCode = JsonResponse::HTTP_BAD_REQUEST);
  }
```

#### Example
```php
  use Anhzf\LaravelRestAPI\APIResponse;
  
  return APIResponse::message('Fetched users data from database')
      ->sendData(compact('userData'));
 ```
