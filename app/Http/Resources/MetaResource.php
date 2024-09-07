<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource
{
    public $resource;
    public $message;
    public $code;

    public function __construct($resource, $message = null, $code = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->code = $code;
    }

    public function toArray(Request $request): array
    {
        $response = [
            'success'   => true,
            'data'      => $this->resource,
        ];

        if (!is_null($this->message)) {
            $response['message'] = $this->message;
        }

        return $response;
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode($this->code);
    }
}
