<?php
namespace Src\Services;

class OktaApiService
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $metadataUrl;

    public function __construct()
    {
        $this->clientId     = getenv('OKTA_CLIENT_ID');
        $this->clientSecret = getenv('OKTA_CLIENT_SECRET');
        $this->redirectUri  = getenv('OKTA_REDIRECT_URI');
        $this->metadataUrl  = getenv('OKTA_METADATA_URL');
    }

    public function buildAuthorizeUrl($state)
    {
        $metadata = $this->httpRequest($this->metadataUrl);
        $url = $metadata->authorization_endpoint . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
            'scope' => 'openid email',
        ]);

        return $url;
    }

    public function authorizeUser($state)
    {
        if ($state != $_GET['state']) {
            $result['error'] = true;
            $result['errorMessage'] = 'Authorization server returned an invalid state parameter';
            return $result;
        }

        if (isset($_GET['error'])) {
            $result['error'] = true;
            $result['errorMessage'] = 'Authorization server returned an error: '.htmlspecialchars($_GET['error']);
            return $result;
        }

        $metadata = $this->httpRequest($this->metadataUrl);

        $response = $this->httpRequest($metadata->token_endpoint, [
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);

        if (! isset($response->id_token)) {
            $result['error'] = true;
            $result['errorMessage'] = 'Error fetching ID token!';
            return $result;
        }

        $claims = json_decode(base64_decode(explode('.', $response->id_token)[1]));

        $result['username'] = $claims->email;
        $result['success'] = true;
        return $result;
    }

    private function httpRequest($url, $params = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        return json_decode(curl_exec($ch));
    }
}
