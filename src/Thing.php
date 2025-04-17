<?php

namespace Clubdeuce\Schema;

/**
 * Class Base
 *
 * @link https://schema.org/Thing
 *
 * @method string description()
 * @method string image_url()
 * @method string name()
 * @method string url()
 * @method void   set_description(string $description)
 * @method void   set_name(string $name)
 * @method void   set_url(string $url)
 * @method void   set_image_url (string $url)
 */
class Thing
{

    /**
     * @var string
     */
    protected string $_description = '';

    /**
     * @var array
     */
    protected array $_extra_args = array();

    /**
     * @var string
     */
    protected string $_image_url = '';

    /**
     * @var string
     */
    protected string $_name = '';

    /**
     * @var string
     */
    protected string $_url = '';

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
            'image' => $this->image_url(),
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

    protected function _set_state(array $args = [])
    {
        foreach ($args as $key => $value) {
            $name = "_{$key}";
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
                continue;
            }

            $this->_extra_args[$key] = $value;
        }
    }
}
