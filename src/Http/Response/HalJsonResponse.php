<?php

namespace Halpert\Http\Response;

use Halpert\Model\AbstractHalResource;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HalJsonResponse
 * @package Halpert\Http\Response
 */
class HalJsonResponse extends JsonResponse
{
    /**
     * HalJsonResponse constructor.
     * @param AbstractHalResource $model
     * @param int $status
     * @param array $headers
     */
    public function __construct(AbstractHalResource $model, $status = 200, array $headers = [])
    {
        $headers['Content-type'] = 'application/hal+json';
        parent::__construct($model, $status, $headers);
    }
}
