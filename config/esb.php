<?php

use Tochka\EsbAdapter\Contracts\EsbEvent;
use Tochka\EsbAdapter\Contracts\EsbRequest;
use Tochka\EsbAdapter\Contracts\EsbResponse;
use Tochka\EsbAdapter\Middleware\AntiDoubleMessages;
use Tochka\EsbAdapter\Middleware\FieldsToXml;
use Tochka\EsbAdapter\Middleware\FillDefaultMessage;
use Tochka\EsbAdapter\Middleware\Log;
use Tochka\EsbAdapter\Middleware\MessageHandleManagement;
use Tochka\EsbAdapter\Middleware\MultiBankExchange;
use Tochka\EsbAdapter\Middleware\RequestContext;

return [
    // настройки подключения (null - use default connection)
    'connection' => null,

    // роутинг исходящих сообщений
    'router' => [
        EsbRequest::class => 'esb.requests.out',
        EsbResponse::class => 'esb.responses.out',
        EsbEvent::class => 'esb.events.out',
    ],

    // какие входящие очереди слушать
    'listen' => [
        'requests' => 'esb.requests.in',
        'responses' => 'esb.responses.in',
        'events' => 'esb.events.in',
    ],

    // посредники
    'middleware' => [
        // парсинг XML в поля объекта
        FieldsToXml::class,
        // заполнение исходящего сообщения данными (тип, время, уникальный идентификатор, отправитель)
        FillDefaultMessage::class => [
            'sender' => 'service',
        ],
        // дополнительные заголовки для мультибанка
        MultiBankExchange::class,
        // логирование всех сообщений
        Log::class => [
            'channel' => 'esb',
            'logMessageBody' => false,
        ],
        // передача данных между запросом и ответом
        RequestContext::class => [
            'connection' => null,
            'table' => 'esb_requests',
        ],
        // управление обработкой сообщения на этапе разбора
        MessageHandleManagement::class,
        // защита от повторной обработки дублированного сообщения
        AntiDoubleMessages::class => [
            'connection' => null,
            'table' => 'esb_messages',
        ],
    ],

    // где искать классы сообщений
    'messageNamespaces' => [
        'requests' => [],
        'responses' => [],
        'events' => [],
    ],

    'auto_clean' => [
        'period' => null,
        'cron' => '0 3 * * *',
    ],
];
