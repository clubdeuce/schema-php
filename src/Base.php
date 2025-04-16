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
 * @method void   set_description( string $description )
 * @method void   set_name( string $name )
 * @method void   set_url( string $url )
 * @method void   set_image_url ( string $url )
 */
class Base {

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
     * @return string[]
     */
    public function schema() : array {

        $schema = array_filter( array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Thing',
            'description' => $this->description(),
            'image'       => $this->image_url(),
            'name'        => $this->name(),
            'url'         => $this->url(),
        ) );

        return $schema;

    }

    /**
     *
     */
    public function the_ld_json() : void {

        if ( $schema = $this->schema() ) {
            printf( '<script type="application/ld+json">%1$s</script>', json_encode( array_filter ( $schema ) ) );
        }

    }

    /**
     * @param string $method
     * @param array  $args
     *
     * @return mixed|null
     */
    public function __call( $method, $args = array() ) {

        if ( preg_match( '#^set_(.*?)$#', $method, $matches ) ) {
            if( property_exists( $this, $property = "_{$matches[1]}" ) ) {
                $this->{$property} = $args[0];
                $value = $args[0];
            }
        }

        if ( preg_match( '#^add_(.*?)$#', $method, $matches ) ) {
            if ( property_exists( $this, $property = "_{$matches[1]}" ) ) {
                if ( is_array( $this->{$property} ) ) {
                    foreach( $args as $param ) {
                        array_push( $this->{$property}, $param );
                    }
                    $value = count( $this->{$property} );
                }

                if ( ! is_array( $this->{$property} ) ) {
                    $value = null;
                    trigger_error( sprintf( 'The %1$s method expects %4$s::%2$s to be an array, while it is %3$s', $method, $property, gettype( $args ), __CLASS__ ) );
                }
            }
        }

        if ( ! isset( $property ) ) {
            $property = "_{$method}";
        }

        if ( property_exists( $this, $property ) ) {
            $value = $this->{$property};
        }

        if ( ! property_exists( $this, $property ) ) {
            $value = null;
            trigger_error( sprintf( 'There is no property named %1$s in %2$s.', $property, __CLASS__ ) );
        }

        return $value;

    }

    protected function _set_state(array $args = []) {
        foreach($args as $key => $value) {
            $name = "_{$key}";
            if(property_exists($this, $name)) {
                $this->{$name} = $value;
                continue;
            }

            $this->_extra_args[$key] = $value;
        }
    }
}
