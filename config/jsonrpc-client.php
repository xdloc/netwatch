<?php

return [
    // Имя клиента. Используется в качестве префикса к ID запросов
    'clientName'  => 'netwatch',

    // Соединение по умолчанию
    'default'     => 'api',

    // Список соединений
    'connections' => [
        // Наименование соединения
        'acquiring.internet' => [
            // URL-адрес JsonRpc-сервера
            'url'             => '',
            // Имя прокси-класса для данного соединения
            'clientClass'     => '\\App\\Api\\Client',
            // Генерация расширенного описания АПИ в виде классов-хелперов для входных и выходных параметров методов
            'extendedStubs'   => false,
            'middleware'      => [
//                \Tochka\JsonRpcClient\Middleware\AdditionalHeadersMiddleware::class => [
//                    'headerName1' => 'headerValue',
//                    'headerName2' => ['value1', 'value2',], // To include multiple headers with the same name
//                ],

                \Tochka\JsonRpcClient\Middleware\AuthTokenMiddleware::class => [
                    'name'  => 'X-Access-Key',
                    'value' => 'TokenValue',
                ],

                \Tochka\JsonRpcClient\Middleware\AuthBasicMiddleware::class => [
                    'scheme'   => 'safe',
                    'username' => 'username',
                    'password' => 'password',
                ],
            ],
            'namedParameters' => true,
            'options' => [], // Опции соединения
        ],
    ],
];
