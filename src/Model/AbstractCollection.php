<?php

namespace Halpert\Model;

use mrkrstphr\CommonPaginator\PaginatorInterface;

/**
 * Class AbstractCollection
 * @package Halpert\Model
 */
abstract class AbstractCollection extends AbstractHalResource
{
    /**
     * @var PaginatedInterface
     */
    protected $data;

    /**
     * @var int
     */
    protected $defaultPerPage = 25;

    /**
     * AbstractCollection constructor.
     * @param PaginatorInterface $data
     */
    public function __construct(PaginatorInterface $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    abstract protected function getName() : string;

    /**
     * @return string
     */
    abstract protected function getModel() : string;

    /**
     * @return int
     */
    protected function perPage() : int
    {
        return $this->defaultPerPage;
    }

    /**
     * @return array
     */
    protected function items() : array
    {
        return $this->data->items();
    }

    /**
     * @return array
     */
    public function render() : array
    {
        $ctor = $this->getModel();

        foreach ($this->data->items() as $item) {
            $this->addEmbeddedResource($this->getName(), new $ctor($item));
        }

        return [
            'count' => count($this->data->items()),
            'total' => $this->data->total(),
            'per_page' => $this->perPage()
        ];
    }
}
