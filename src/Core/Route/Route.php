<?php

namespace MiniFast\Core\Route;

use \MiniFast\Config;

class Route
{
    protected $models;
    protected $view;
    protected $response;
    protected $name;

    public function __construct(array $content)
    {
        $this->setName($content);
        $this->setModels($content);
        $this->setView($content);
    }

    /**
     * Parse the route as an array and retrieve data
     * @param  array  $content The route as an array
     * @param  string $index   The index to find
     * @param  string $class   The classname of the element
     * @return array           An array filled with objects
     */
    private function arraySetter(array $content, string $index): array
    {
        $items = [];

        if (isset($content[$index])) {
            if (is_array($content[$index])) {
                foreach ($content[$index] as $item) {
                    if (is_string($model)) {
                        $items[] = $item;
                    }
                }
            } elseif (is_string($content[$index])) {
                $items[] = $content[$index];
            }
        }

        return $items;
    }

    /**
     * Parse a route as an array and retrieve data
     * @param  array  $content The route as an array
     * @param  string $index   The index to find
     * @return string          The string in $index index
     */
    private function stringSetter(array $content, string $index): ?string
    {
        $item = null;

        if (isset($content[$index])) {
            if (!empty($content[$index])) {
                if (is_string($content[$index])) {
                    $item = $content[$index];
                } else {
                    throw new \Exception("$index name must be a string.");
                }
            }
        }

        return $item;
    }

    /**
     * Set the name of the route
     * @param array $content The content of the route
     */
    private function setName(array $content): string
    {

        if (isset($content[Config::ROUTER_ROUTES_NAME_INDEX])) {
            return $this->name = $content[Config::ROUTER_ROUTES_NAME_INDEX];
        }

        throw new \Exception('A route cannot have an empty name.');
    }

    /**
     * Return the name of the route
     * @return string The name of the route
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieve model names from $content
     * @param array $content The route as an array
     */
    private function setModels(array $content): void
    {
        $this->models = $this
            ->arraySetter($content, Config::ROUTER_ROUTES_MODELS);
    }

    /**
     * Return all models in the route
     * @return array All models in an array
     */
    public function getModels(): array
    {
        return $this->models;
    }

    /**
     * Retrieve the view name from $content
     * @param array $content The route as a string
     */
    private function setView(array $content): void
    {
        $this->view = $this
            ->stringSetter($content, Config::ROUTER_ROUTES_VIEW);
    }

    /**
     * Return the view name in the route
     * @return string The view name
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    public function use()
    {
        $model = new Model();

        // Call all models
        foreach ($this->models as $key => $name) {
            $model->use($name);
        }
    }
}
