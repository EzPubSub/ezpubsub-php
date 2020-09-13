<?php

namespace EzPubSub;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EzPubSub
{
    private $host;
    private $ext;
    private $client;

    /**
     * EzPubSub constructor.
     * @param $app_id
     * @param $key
     * @param $secret
     * @param $cluster
     * @throws EzPubSubException
     */
    public function __construct($app_id, $key, $secret, $cluster)
    {
        $this->checkCompatibility();
        $this->client = new Client();
        $this->host = "https://$cluster.ezpubsub.com";
        $this->ext = [
            'key' => $key,
            'secret' => $secret,
            'app_id' => $app_id
        ];
    }

    /**
     * @param $channel
     * @param $data
     * @return void
     * @throws EzPubSubException
     * @throws GuzzleException
     */
    public function trigger($channel, $data)
    {
        if (!is_string($channel)) {
            foreach ($channel as $ch) {
                $this->publish([
                    'channel' => $this->getChannel($ch),
                    'data' => $data,
                    'ext' => $this->ext,
                ]);
            }
        } else {
            $this->publish([
                'channel' => $this->getChannel($channel),
                'data' => $data,
                'ext' => $this->ext,
            ]);
        }
    }

    /**
     * @param $batch
     * @throws EzPubSubException
     * @throws GuzzleException
     */
    public function triggerBatch($batch)
    {
        foreach ($batch as $ch)
        {
            $this->trigger($ch['channel'], $ch['data']);
        }
    }

    /**
     * @param $message
     * @return bool
     * @throws EzPubSubException
     * @throws GuzzleException
     */
    private function publish($message)
    {
        try {
            $response = $this->client->request('POST', $this->host , [
                'form_params' =>  [
                    'message' => json_encode($message)
                ]
            ]);
            return $response->getStatusCode() == 200 ? true : false;
        } catch (Exception $e) {
            throw new EzPubSubException($e->getMessage());
        }
    }

    /**
     * @param $channel
     * @return string
     */
    private function getChannel($channel)
    {
        return '/'.$this->ext['app_id'].'/'.$channel;
    }

    /**
     * @throws EzPubSubException
     */
    private function checkCompatibility()
    {
        if (!extension_loaded('curl')) {
            throw new EzPubSubException('requires the PHP cURL module. Please ensure it is installed');
        }

        if (!extension_loaded('json')) {
            throw new EzPubSubException('requires the PHP JSON module. Please ensure it is installed');
        }
    }
}
