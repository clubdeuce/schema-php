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
    protected array $extraArgs = [];

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
            return sprintf('<script type="application/ld+json">%1$s</script>', json_encode($schema));
        }

        return '';
    }

    /**
     * @return string[]
     */
    public function schema(): array
    {
        $schema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Thing',
            'description' => $this->description(),
            'image' => $this->imageUrl(),
            'name' => $this->name(),
            'url' => $this->url(),
        ]);

        return $schema;
    }

    protected function getSchema(string $propertyName): array
    {
        $schema = [];

        if (property_exists($this, $propertyName)) {
            foreach ($this->{$propertyName} as $item) {
                /** @var Thing $item */
                $schema[] = $item->schema();
            }
        }

        return $schema;
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
