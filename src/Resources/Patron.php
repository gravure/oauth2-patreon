<?php

namespace Gravure\Patreon\Oauth\Resources;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Patron implements ResourceOwnerInterface
{
    protected $id;

    protected $attributes = [];

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->attributes = $data['attributes'];
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge([
            'id' => $this->id
        ], $this->attributes);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->attributes['email'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->attributes['full_name'];
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->attributes['image_url'];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->attributes['vanity'];
    }
}
