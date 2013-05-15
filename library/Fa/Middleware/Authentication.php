<?php

/**
 * Flaming Archer
 *
 * @link      http://github.com/jeremykendall/flaming-archer for the canonical source repository
 * @copyright Copyright (c) 2012 Jeremy Kendall (http://about.me/jeremykendall)
 * @license   http://github.com/jeremykendall/flaming-archer/blob/master/LICENSE MIT License
 */

namespace Fa\Middleware;

use Zend\Authentication\AuthenticationService;

/**
 * Authentication middleware
 *
 * Checks if user is authenticated when user visiting secured URI. Will redirect
 * a user to login if they attempt to visit a secured URI and are not authenticated
 */
class Authentication extends \Slim\Middleware
{

    /**
     * Authentication service
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     * @var array
     */
    private $config;

    /**
     * Public constructor
     *
     * @param AuthenticationService $auth Authentication service
     */
    public function __construct(AuthenticationService $auth, array $config)
    {
        $this->auth = $auth;
        $this->config = $config;
    }

    /**
     * Uses 'slim.before.router' to check for authentication when visitor attempts
     * to access a secured URI. Will redirect unauthenticated user to login page.
     */
    public function call()
    {
        $app = $this->app;
        $auth = $this->auth;
        $req = $app->request();
        $config = $this->config;

        $this->app->hook('slim.before.router', function () use ($app, $auth, $req, $config) {
                $securedUrls = isset($config['security.urls']) ? $config['security.urls'] : array();
                foreach ($securedUrls as $surl) {
                    $patternAsRegex = $surl['path'];
                    $patternAsRegex = '@^' . $patternAsRegex . '$@';
                    if (preg_match($patternAsRegex, $req->getPathInfo())) {
                        if (!$auth->hasIdentity()) {
                            if ($req->getPath() !== $config['login.url']) {
                                $app->redirect($config['login.url']);
                            }
                        }
                    }
                }
            }
        );

        $this->next->call();
    }

}
