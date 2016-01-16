<?php

namespace Halpert\Model;

/**
 * Class AbstractViewModel
 * @package Halpert\Model
 */
abstract class AbstractViewModel extends AbstractHalResource
{
    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @param mixed $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
