<?php

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Exception\IssuedInTheFuture;
use Kreait\Firebase\Exception\Messaging\AuthenticationError;
use Kreait\Firebase\Exception\Messaging\InvalidArgument;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Firebase
{
    private $firebase;
    private $payloadData;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->loadServiceAccount();
    }

    public function createDataPayload($data)
    {
        $this->payloadData = $data;

        return $this;
    }

    public function sendToTopic($topic, $options = [])
    {
        $message = [
            'topic' => $topic,
            'data' => array_merge([
                'sound' => 'default'
            ], $this->payloadData),
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => array_merge([
                        'alert' => array_merge([
                            'sound' => 'default'
                        ], $this->payloadData),
                        'badge' => 1,
                        'mutable-content' => 1,
                        'sound' => 'default'
                    ], $options),
                ],
            ]
        ];
        //TODO HANDLE EXCEPTION, UPDATE FCM TOKEN IN DB
        try {
            $this->firebase->getMessaging()->send($message);
        } catch (IssuedInTheFuture $e) {
            log_message('error', 'IssuedInTheFuture ' . $e->getMessage());
        } catch (InvalidToken $e) {
            log_message('error', 'InvalidToken ' . $e->getMessage());
        } catch (NotFound $e) {
            log_message('error', 'NotFound ' . $e->getMessage());
        } catch (InvalidArgument $e) {
            log_message('error', 'InvalidArgument ' . $e->getMessage());
        } catch (AuthenticationError $e) {
            log_message('error', 'AuthenticationError ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Exception ' . $e->getMessage());
        }
    }

    private function jsonFilePath()
    {
        return $this->CI->config->item('firebase_app_key');
    }

    private function loadServiceAccount()
    {
        $serviceAccount = ServiceAccount::fromJsonFile($this->jsonFilePath());
        $this->firebase = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
    }

}