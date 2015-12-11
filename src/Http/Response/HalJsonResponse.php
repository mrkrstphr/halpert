<?php

namespace Halpert\Http\Response;

use Halpert\Model\AbstractViewModel;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HalJsonResponse
 * @package Halpert\Http\Response
 */
class HalJsonResponse extends JsonResponse
{
    /**
     * HalJsonResponse constructor.
     * @param AbstractViewModel $model
     * @param int $status
     * @param array $headers
     */
    public function __construct(AbstractViewModel $model, $status = 200, array $headers = [])
    {
        $headers['Content-type'] = 'application/hal+json';
        parent::__construct($model, $status, $headers);
    }
}
