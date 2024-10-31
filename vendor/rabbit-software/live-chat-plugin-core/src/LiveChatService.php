<?php

declare(strict_types=1);

namespace Rabbit\LiveChatPluginCore;

use JsonException;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as HttpClient;
use Rabbit\LiveChatPluginCore\Exception\AuthenticationResponseException;
use Rabbit\LiveChatPluginCore\Exception\LiveChatException;
use Rabbit\LiveChatPluginCore\ValueObject\AuthenticationResponse;
use Throwable;

class LiveChatService
{
    public function __construct(
        private string $apiKey,
        private string $apiSecret,
        private HttpClient $httpClient,
        private string $host = 'plugins.rabbit.nl',
    ) {
    }

    /**
     * @throws LiveChatException
     * @throws JsonException
     */
    public function fetchToken(): AuthenticationResponse
    {
        try {
            $body = json_encode([
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
            ], JSON_THROW_ON_ERROR);
        // @codeCoverageIgnoreStart
        } catch (JsonException $e) {
            throw LiveChatException::becauseFailedToEncode($e);
        }
        // @codeCoverageIgnoreEnd

        $uri = (new Uri())
        ->withScheme('https')
        ->withHost($this->host)
        ->withPath('api/plugins/live-chat/auth/login');

        $request = (new Request(
            method: 'POST',
            uri: $uri,
            body: $body,
        ))
        ->withHeader('Content-Type', 'application/json; charset=utf-8')
        ->withHeader('Accept', 'application/json');

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface | Throwable $e) {
            throw LiveChatException::becauseFailedToMakeRequest($e);
        }

        if ($response->getStatusCode() >= 400) {
            throw LiveChatException::becauseOfBadResponse($response->getStatusCode());
        }

        try {
            $responseBody = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw LiveChatException::becauseFailedToDecode($e);
        }

        if (!array_key_exists('data', $responseBody)) {
            throw LiveChatException::becauseOfResponseHasNoData();
        }

        try {
            $authenticationResponse = AuthenticationResponse::createFromArray($responseBody['data']);
        } catch (AuthenticationResponseException $e) {
            throw LiveChatException::becauseUnableToCreateAuthenticationResponse($e);
        }

        return $authenticationResponse;
    }
}
