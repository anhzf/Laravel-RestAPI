<?php

namespace Anhzf\LaravelRestAPI;

use Illuminate\Http\JsonResponse;

/**
 * @method static \Illuminate\Http\JsonResponse send()
 * @method static self message(string $message)
 * @method static self error()
 * @method static self data(array $data)
 * @method static \Illuminate\Http\JsonResponse sendMessage(string $message)
 * @method static \Illuminate\Http\JsonResponse sendError(string $message = null, int $statusCode = \Illuminate\Http\JsonResponse::HTTP_BAD_REQUEST)
 * @method static \Illuminate\Http\JsonResponse sendData(array $data)
 * @method static \Illuminate\Http\JsonResponse sendStatusCode(int $statusCode, bool $success = true)
 * @method static array toArray()
 *
 * @see \Illuminate\Http\JsonResponse
 */
class APIResponse
{
    private static $_instance = null;
    private static array $data;
    private static string $message;
    private static bool $success = true;
    private static int $statusCode = JsonResponse::HTTP_OK;


    /**
     * Send formatted RestAPI as Json response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function send(/* array $params = [] */)
    {
        return new JsonResponse(self::toArray(), self::$statusCode);
    }

    /**
     * Set message for RestAPI Response
     *
     * @param  string  $message
     * @return self
     */
    public static function message(string $message): self
    {
        self::init();
        self::$message = $message;
        return self::$_instance;
    }

    /**
     * Set error for RestAPI response
     *
     * @return self
     */
    public static function error(): self
    {
        self::init();
        self::$success = false;
        return self::$_instance;
    }

    /**
     * Set data to RestAPI Response
     *
     * @param  array    $data
     * @return self
     */
    public static function data(array $data): self
    {
        self::init();
        self::$data = $data;
        return self::$_instance;
    }

    /**
     * Set status code
     *
     * @param  int  $statusCode
     * @return self
     */
    public static function statusCode(int $statusCode): self
    {
        self::init();
        self::$statusCode = $statusCode;
        return self::$_instance;
    }

    /**
     * Directly send message api response
     *
     * @param  string   $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendMessage(string $message)
    {
        self::init();
        self::$_instance->message($message);
        return self::$_instance->send();
    }

    /**
     * Send error api response
     *
     * @param  string   $message
     * @param  int      $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendError(string $message = null, int $statusCode = JsonResponse::HTTP_BAD_REQUEST)
    {
        self::init();
        self::$_instance->error();
        self::$_instance->message($message);
        self::$_instance->statusCode($statusCode);
        return self::$_instance->send();
    }

    /**
     * Pass data and send it
     *
     * @param  array    $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendData(array $data)
    {
        self::init();
        self::$_instance->data($data);
        return self::$_instance->send();
    }

    public static function sendStatusCode(int $statusCode, bool $success = true)
    {
        self::init();
        self::$_instance->statusCode($statusCode);
        if (!$success) {
            self::$_instance->error();
        }
        return self::$_instance->send();
    }

    /**
     * Get what RestAPI will be send
     *
     * @return array
     */
    public static function toArray()
    {
        $res = [];

        if (!empty(self::$success))
            $res['success'] = self::$success;

        if (!empty(self::$data))
            $res['data'] = self::$data;

        if (!empty(self::$message))
            $res['message'] = self::$message;

        return $res;
    }

    /**
     * Initialize to use this Class
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    private static function init()
    {
        if (is_null(self::$_instance))
            self::$_instance = new self;
    }
}
