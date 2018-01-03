<?php

namespace Ipag\Http;

final class CurlOnlyPostHttpClient implements OnlyPostHttpClientInterface
{
    private $httpHeaders;
    private $httpPostFields;

    public function __invoke($endpoint, array $headers = [], array $fields = [])
    {
        $this->httpHeaders = $this->formatToHttpHeaders($headers);
        $this->httpPostFields = $this->formatToHttpPostFields($fields);

        return $this->post($endpoint);
    }

    protected function post($endpoint)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->httpPostFields);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
        curl_setopt($curl, CURLOPT_USERAGENT, 'IPAG_SDK_PHP');

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
}
