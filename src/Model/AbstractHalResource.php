<?php

namespace Halpert\Model;

use JsonSerializable;

/**
 * Class AbstractHalResource
 * @package Halpert\Model
 */
abstract class AbstractHalResource implements JsonSerializable
{
    /**
     * @var array
     */
    protected $embedded = [];

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @return string
     */
    abstract public function getSelfPath() : string;

    /**
     * @param string $name
     * @param string $href
     */
    protected function addLink(string $name, string $href)
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
     * @param string $key
     * @param AbstractViewModel $embedded
     */
    protected function addEmbeddedResource(string $key, AbstractViewModel $embedded)
    {
        if (!array_key_exists($key, $this->embedded)) {
            $this->embedded[$key] = [];
        }

        $this->embedded[$key][] = $embedded->jsonSerialize();
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
    abstract public function render() : array;

    /**
     * @return array
     */
    public function jsonSerialize() : array
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
    private function buildLinks(array $data) : array
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
    private function buildEmbedded(array $data) : array
    {
        $this->addEmbeddedResources();

        if ($this->embedded) {
            $data['_embedded'] = $this->embedded;
        }

//        foreach ($this->embedded as $embedded) {
//            if (!array_key_exists($embedded['name'], $data['_embedded'])) {
//                $data['_embedded'][$embedded['name']] = [];
//            }
//
//            $data['_embedded'][$embedded['name']][] = $embedded['resource'];
//        }

        return $data;
    }
}
