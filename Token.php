<?php

/**
 * Description of Token
 *
 * @author ondrej-maxa
 */
class Token
{

    /**
     * Your google drive client.
     *
     * @var Google_Client
     */
    private $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        if (!is_null(filter_input(INPUT_COOKIE, 'token'))) {
            // TOKEN EXISTS
            $this->get();
        }
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                // TOKEN IS EXPIRED
                $this->refresh();
            } else {
                // TOKEN IS NOT CREATED YET
                $this->create();
            }
        }
    }

    /**
     * Resets token.
     */
    public function reset()
    {
        $this->setCookie(true);
    }

    /**
     * Gets token.
     * Called only if token exists.
     */
    private function get()
    {
        $accessToken = json_decode(filter_input(INPUT_COOKIE, 'token'), true);
        $this->client->setAccessToken($accessToken);
    }

    /**
     * Refreshes token.
     * Called only if token doesn't exist but refresh token does.
     */
    private function refresh()
    {
        $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        $this->setCookie();
    }

    /**
     * Creates new token.
     */
    private function create()
    {
        if (!is_null(filter_input(INPUT_GET, 'code'))) {
            $this->client->authenticate(filter_input(INPUT_GET, 'code'));
            $this->setCookie();
            $redirectUri = json_decode(file_get_contents($this->pathToCredentials),
                    true)["web"]["redirect_uris"][0];
            header("Location: $redirectUri?login");
        } else {
            $authUrl = $this->client->createAuthUrl();
            header('Location: '.filter_var($authUrl, FILTER_SANITIZE_URL));
        }
    }

    /**
     * Stores or deletes token from Cookie
     *
     * @param bool $delete If the cookie should be unset.
     */
    private function setCookie($delete = false)
    {
        $time = $delete ? time() - 3600 : time() + 3600;
        setcookie(
            "token", json_encode($this->client->getAccessToken()), $time
        );
    }
}