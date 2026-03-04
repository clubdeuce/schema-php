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

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * Set the image URL
     */
    public function setImageUrl(string $url): static
    {
        $this->imageUrl = $url;
        return $this;
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
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
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

    protected function getSchema(array $items): array
    {
        $schema = [];

        foreach ($items as $item) {
            /** @var Thing $item */
            $schema[] = $item->schema();
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

    protected static function resolvePostalAddress(array $args): array
    {
        if (isset($args['address']) && is_array($args['address'])) {
            $args['address'] = new PostalAddress($args['address']);
        }

        return $args;
    }
}
