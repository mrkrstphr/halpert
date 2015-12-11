<?php

namespace Halpert\Model;

use JsonSerializable;

/**
 * Class AbstractViewModel
 * @package Halpert\Model
 */
abstract class AbstractViewModel implements JsonSerializable
{
    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @var array
     */
    protected $embedded = [];

    /**
     * @var array
     */
    protected $links = [];

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

    /**
     * @return string
     */
    abstract public function getSelfPath();

    /**
     * @param string $name
     * @param string $href
     */
    protected function addLink($name, $href)
    {
        $this->links[$name] = $href;
    }

    /**
     * This method is meant to be extended by the child class. It is called when building the HAL+JSON output to
     * append any additional links to the resource.
     */
    protected function addLinks()
    {
    }

    /**
     * This method is meant to be extended by the child class. It is called when building the HAL+JSON output to
     * append any additional embedded resources.
     */
    protected function addEmbeddedResources()
    {
    }

    /**
     * @return array
     */
    abstract public function render();

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = $this->render();
        $data = $this->buildLinks($data);
        $data = $this->buildEmbedded($data);

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function buildLinks(array $data)
    {
        $this->addLinks();

        if ($this->getSelfPath()) {
            $this->links['self'] = $this->getSelfPath();
        }

        if ($this->links) {
            $data['_links'] = [];
        }

        foreach ($this->links as $name => $link) {
            $data['_links'][$name] = ['href' => $link];
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function buildEmbedded(array $data)
    {
        $this->addEmbeddedResources();

        if ($this->embedded) {
            $data['_embedded'] = [];
        }

        foreach ($this->embedded as $embedded) {
            if (!array_key_exists($embedded['name'], $data['_embedded'])) {
                $data['_embedded'][$embedded['name']] = [];
            }

            $data['_embedded'][$embedded['name']][] = $embedded['resource'];
        }

        return $data;
    }
}
