<?php


namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

/**
 * 接口错误处理返回<code=200>
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends \Exception
{
    const HTTP_OK = 200;
    const HTTP_ERROR = 500;
    const BED_REQUEST = 400;

    protected $data;
    protected $code;

    public function __construct($message, int $code = self::BED_REQUEST, $data = null)
    {
        $this->data = $data;
        $this->code = $code;
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        $content = [
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data ?? null,
            'status' => $this->code != self::HTTP_OK ? 'error' : 'success',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return response()->json($content, self::HTTP_OK);
    }
}
