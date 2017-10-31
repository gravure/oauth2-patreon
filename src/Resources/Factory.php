<?php

namespace Gravure\Patreon\Oauth\Resources;

use Gravure\Patreon\Oauth\Exceptions\InvalidResourceException;

class Factory
{
    /**
     * @var array
     */
    protected static $mapping = [
        'user' => Patron::class,
        'pledge' => Pledge::class,
    ];

    /**
     * @param array $payload
     * @return Resource
     */
    public static function create(array $payload)
    {
        $data = $payload['data'];
        $type = $data['type'];
        $included = $payload['included'];

        if (false === array_key_exists($type, static::$mapping)) {
            throw new InvalidResourceException("Resource type $type not mapped.");
        }

        $class = static::$mapping[$type];

        /** @var Resource $resource */
        $resource = new $class;
        $resource->id = $data['id'];
        $resource->type = $type;
        $resource->attributes = $data['attributes'];

        if (isset($data['relationships']['data'])) {
            foreach ($data['relationships']['data'] as $relationship) {

                dd($relationship);
                array_push(
                    $resource->relationships,
                    static::retrieveIncluded($relationship['type'], $relationship['id'], $included)
                );
            }
        }

        return $resource;
    }

    /**
     * @param $type
     * @param $id
     * @param array $included
     * @return null|void
     */
    protected static function retrieveIncluded($type, $id, array $included = [])
    {
        foreach ($included as $resource) {
            if ($resource['type'] === $type && $resource['id'] === $id) {
                return static::create($resource);
            }
        }

        return null;
    }
}
