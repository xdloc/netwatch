<?php

use Tochka\UniqueQueue\QueueConfiguration;

return [
    'default' => env('UNIQUE_CONNECTION', 'amqp'),

    'connections' => [
        'stomp' => [
            'driver' => 'stomp',
            'broker' => QueueConfiguration::BROKER_RABBITMQ,
            'hosts' => env('RABBITRY_HOST_STOMP_SSL'),
            'username' => env('RABBITRY_USERNAME'),
            'password' => env('RABBITRY_PASSWORD'),
            'vhost' => '/',
            'additional' => [
                'sync' => true,
                'persistent' => true,
                'heartbeat' => [30000, 0],
                'read_timeout' => 10,
            ],
            'wrappers' => [
                'stateful' => [
                    'maxReconnectAttempts' => 10,
                    'delayBetweenReconnect' => 100,
                    'maxDelayBetweenReconnect' => 1000,
                ],
                'delayed' => [
                    'connection' => null,
                    'table' => 'delayed_messages'
                ]
            ]
        ],
        'amqp' => [
            'driver' => 'amqp-ext',
            'broker' => QueueConfiguration::BROKER_RABBITMQ,
            'hosts' => env('RABBITRY_HOST_AMQPS'),
            'username' => env('RABBITRY_USERNAME'),
            'password' => env('RABBITRY_PASSWORD'),
            'vhost' => '/',
            'additional' => [
                'sync' => true,
                'persistent' => true,
                'heartbeat' => 30,
                'read_timeout' => 1,
                'receive_message_algorithm' => 'push',
                'use_default_ca_path' => true,
                'verify' => false,
            ],
            'wrappers' => [
                'stateful' => [
                    'maxReconnectAttempts' => 10,
                    'delayBetweenReconnect' => 100,
                    'maxDelayBetweenReconnect' => 1000,
                ],
                'delayed' => [
                    'connection' => null,
                    'table' => 'delayed_messages'
                ]
            ]
        ],
    ],
];
