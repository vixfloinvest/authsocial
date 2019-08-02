<?php

namespace Laservici\Authsocial;

use InvalidArgumentException;
use Illuminate\Support\Manager;
use Laservici\Authsocial\One\TwitterProvider;
use Laservici\Authsocial\One\BitbucketProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use League\OAuth1\Client\Server\Bitbucket as BitbucketServer;

class AuthsocialManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\Two\AbstractProvider
     */
    protected function createGithubDriver()
    {
        $config = $this->app['config']['services.github'];

        return $this->buildProvider(
            'Laservici\Authsocial\Two\GithubProvider', $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\Two\AbstractProvider
     */
    protected function createFacebookDriver()
    {
        $config = $this->app['config']['services.facebook'];

        return $this->buildProvider(
            'Laservici\Authsocial\Two\FacebookProvider', $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\Two\AbstractProvider
     */
    protected function createGoogleDriver()
    {
        $config = $this->app['config']['services.google'];

        return $this->buildProvider(
            'Laservici\Authsocial\Two\GoogleProvider', $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\Two\AbstractProvider
     */
    protected function createLinkedinDriver()
    {
        $config = $this->app['config']['services.linkedin'];

        return $this->buildProvider(
          'Laservici\Authsocial\Two\LinkedInProvider', $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \Laservici\Authsocial\Two\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'], $config['client_id'],
            $config['client_secret'], $config['redirect']
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\One\AbstractProvider
     */
    protected function createTwitterDriver()
    {
        $config = $this->app['config']['services.twitter'];

        return new TwitterProvider(
            $this->app['request'], new TwitterServer($this->formatConfig($config))
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laservici\Authsocial\One\AbstractProvider
     */
    protected function createBitbucketDriver()
    {
        $config = $this->app['config']['services.bitbucket'];

        return new BitbucketProvider(
            $this->app['request'], new BitbucketServer($this->formatConfig($config))
        );
    }

    /**
     * Format the server configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function formatConfig(array $config)
    {
        return array_merge([
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => $config['redirect'],
        ], $config);
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No AuthSocial driver was specified.');
    }
}
