<?php

namespace SerwerSMS\SerwerSMSBundle\Http;

use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;
use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

abstract class ApiClient implements SerwerSMSInterface
{
    protected readonly string $apiUrl;
    protected readonly int    $timeout;

    public function __construct(
        string $apiUrl  = 'https://api2.serwersms.pl',
        int    $timeout = 30
    ) {
        $this->apiUrl  = rtrim($apiUrl, '/');
        $this->timeout = $timeout;
    }

    /**
     * @param array<string, mixed> $params
     * @throws Exception
     */
    public function call(string $url, array $params = []): object
    {
        $params = array_filter($params, fn($v) => $v !== null);
        $params['system'] = 'symfony8';

        $this->applyAuth($params);

        $endpoint   = $this->apiUrl . '/' . $url . '.json';
        $dataString = json_encode($params);

        if ($dataString === false) {
            throw new Exception('JSON encoding failed: ' . json_last_error_msg());
        }

        $curl = curl_init($endpoint);

        if ($curl === false) {
            throw new Exception('Failed to initialize CURL.');
        }

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->buildHeaders($dataString));

        $answer = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            $errno = curl_errno($curl);
            curl_close($curl);
            throw new Exception('CURL error: ' . $error, $errno);
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) {
            throw new Exception('HTTP error: ' . $httpCode, $httpCode);
        }

        if ($answer === '' || $answer === false) {
            throw new Exception('Empty response from SerwerSMS API.');
        }

        $result = json_decode($answer);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from SerwerSMS API: ' . $answer);
        }

        if (is_null($result)) {
            return new \stdClass();
        }

        if (!is_object($result)) {
            throw new Exception('Unexpected response from SerwerSMS API: ' . $answer);
        }

        if (isset($result->error)) {
            throw new Exception(
                $result->error->message ?? 'Unknown API error',
                (int) ($result->error->code ?? 0)
            );
        }

        return $result;
    }

    /**
     * Modify params or headers for authentication.
     *
     * @param array<string, mixed> $params
     */
    abstract protected function applyAuth(array &$params): void;

    /**
     * @return string[]
     */
    abstract protected function buildHeaders(string $dataString): array;
}
