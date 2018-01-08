<?php

namespace Ipag\Classes\Http;

final class CurlOnlyPostHttpClient implements OnlyPostHttpClientInterface, AuthenticableHttpInterface
{
    const CLIENT = 'IpagSdkPhp';

    private $httpHeaders;
    private $httpPostFields;
    private $userAgent;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __invoke($endpoint, array $headers = [], array $fields = [])
    {
        $this->httpHeaders = $this->formatToHttpHeaders($headers);
        $this->httpPostFields = $this->formatToHttpPostFields($fields);
        $this->userAgent = sprintf('%s (+https://github.com/jhernandes/ipag-sdk-php/)', self::CLIENT);

        return $this->post($endpoint);
    }

    protected function post($endpoint)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_USERPWD, "{$this->user}:{$this->password}");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->httpPostFields);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);

        $response = curl_exec($curl);

        $this->curlHasError($curl);

        curl_close($curl);

        return $response;
    }

    private function formatToHttpHeaders(array $headers = [])
    {
        return array_map(
            function ($name, $value) {
                return "{$name}: {$value}";
            },
            array_keys($headers),
            array_values($headers)
        );
    }

    private function formatToHttpPostFields(array $fields = [])
    {
        $formattedFields = '';
        foreach ($fields as $name => $value) {
            $formattedFields .= "{$name}={$value}&";
        }
        rtrim($formattedFields, '&');

        return $formattedFields;
    }

    private function curlHasError($curl)
    {
        if (curl_errno($curl)) {
            throw new \Exception('Curl error: '.curl_error($curl));
        }
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
