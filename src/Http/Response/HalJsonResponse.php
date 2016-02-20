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
    protected $rawData;

    /**
     * HalJsonResponse constructor.
     * @param AbstractHalResource $model
     * @param int $status
     * @param array $headers
     */
    public function __construct(AbstractHalResource $model, $status = 200, array $headers = [])
    {
        $headers['Content-type'] = 'application/hal+json';
        parent::__construct('', $status, $headers);

        $this->rawData = $model;
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws \Exception
     */
    public function setData($data = [])
    {
        return parent::setData($data ?: $this->rawData);
    }
}
