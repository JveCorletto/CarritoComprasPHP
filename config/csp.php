<?php

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;

return [
    'policy' => Spatie\Csp\Policies\Basic::class,
    
    'report_only_policy' => '',
    
    'enabled' => env('CSP_ENABLED', true),

    'nonce_generator' => null, // Si no necesitas un nonce específico, puedes dejarlo como null
    
    'policies' => [
        Spatie\Csp\Policies\Basic::class => [
            Directive::STYLE => [
                Keyword::SELF,
                'https://*.paypal.com',
                'https://*.paypal.cn',
                'https://*.paypalobjects.com',
                'https://objects.paypal.cn',
                Keyword::UNSAFE_INLINE,
            ],

            Directive::SCRIPT => [
                Keyword::SELF,
                'https://*.paypal.com',
                'https://*.paypal.cn',
                'https://*.paypalobjects.com',
                'https://objects.paypal.cn',
            ],

            Directive::CONNECT => [
                Keyword::SELF,
                'https://*.paypal.com',
                'https://*.paypalobjects.com',
            ],
            
            Directive::IMG => [
                Keyword::SELF,
                'https://*.paypal.com',
                'https://*.paypalobjects.com',
            ],
        ],
    ],
];