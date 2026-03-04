<?php

namespace Clubdeuce\Schema;

/**
 * Class Base
 *
 * @link https://schema.org/Thing
 */
class Thing
{
    protected string $description = '';
    protected array $extraArgs = array();

    protected string $imageUrl = '';
    protected string $name = '';
    protected string $url = '';

    public function __construct(array $args = [])
    {
        $this->setState($args);
    }

    public function description(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * Set the image URL
     */
    public function setImageUrl(string $url): void
    {
        $this->imageUrl = $url;
    }

    /**
     * Get the name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Set the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     *
     */
    public function ldJson(): string
    {
        if ($schema = $this->schema()) {
            return sprintf('<script type="application/ld+json">%1$s</script>', json_encode(array_filter($schema)));
        }

        return '';
    }

    /**
     * @return string[]
     */
    public function schema(): array
    {
        $schema = array_filter(array(
            '@context' => 'https://schema.org',
            '@type' => 'Thing',
            'description' => $this->description(),
            'image' => $this->imageUrl(),
            'name' => $this->name(),
            'url' => $this->url(),
        ));

        return $schema;
    }

    /**
     * @param string $method
     * @param array $args
     *
     * @return mixed|null
     */
    public function __call(string $method, array $args = array())
    {
        $msg = sprintf('Magic methods are deprecated. Please implement %2$s::%1$s.', $method, static::class);
        trigger_error($msg);

        if (preg_match('#^set_(.*?)$#', $method, $matches)) {
            if (property_exists($this, $property = "_{$matches[1]}")) {
                $this->{$property} = $args[0];
                return $args[0];
            }
        }

        if (preg_match('#^add([A-Z].*?)$#', $method, $matches)) {
            $property = '_' . lcfirst($matches[1]);
            if (property_exists($this, $property)) {
                if (is_array($this->{$property})) {
                    foreach ($args as $param) {
                        $this->{$property}[] = $param;
                    }
                    return count($this->{$property});
                }

                trigger_error(sprintf('The %1$s method expects %4$s::%2$s to be an array, while it is %3$s', $method, $property, gettype($args), __CLASS__));
                return null;
            }
        }

        if (!isset($property)) {
            $property = "_{$method}";
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        trigger_error(sprintf('There is no property named %1$s in %2$s.', $property, __CLASS__));
        return null;
    }

    protected function setState(array $args = []): void
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
                continue;
            }

            $this->extraArgs[$key] = $value;
        }
    }
}
