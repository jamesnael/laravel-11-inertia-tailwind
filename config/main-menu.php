<?php

return [
    'menu' => [
        [
            'uniqid' => 'menuHomePage',
            'type' => 'menu',
            'text' => 'Home Page',
            'route' => '#',
            'access' => [
                'module.homepage.sliding-banner.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'slidingBanner',
                    'type' => 'menu',
                    'text' => 'Sliding Banner',
                    'route' => 'admin.homepage.sliding-banner.index',
                    'access' => 'module.homepage.sliding-banner.index',
                    'active' => false,
                    'open' => false,
                    'subopen' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'homeAbout',
                    'type' => 'menu',
                    'text' => 'Introduction',
                    'route' => 'admin.homepage.home-about.index',
                    'access' => 'module.homepage.home-about.index',
                    'active' => false,
                    'open' => false,
                    'subopen' => false,
                    'children' => null
                ],
                // [
                //     'uniqid' => 'supportedBy',
                //     'type' => 'menu',
                //     'text' => 'Supported By',
                //     'route' => 'admin.homepage.supported-by.index',
                //     'access' => 'module.homepage.supported-by.index',
                //     'active' => false,
                //     'open' => false,
                //     'children' => null
                // ]
            ]
        ],
        [
            'uniqid' => 'menuSettings',
            'type' => 'menu',
            'text' => 'Settings (Master Data)',
            'route' => '#',
            'access' => [
                'module.settings.jabatan.index',
                'module.registration-user.index'
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'masterGroupUser',
                    'type' => 'menu',
                    'text' => 'Group User',
                    'route' => 'admin.settings.jabatan.index',
                    'access' => 'module.settings.jabatan.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterUser',
                    'type' => 'menu',
                    'text' => 'User',
                    'route' => 'admin.settings.karyawan.index',
                    'access' => 'module.settings.karyawan.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterMeta',
                    'type' => 'menu',
                    'text' => 'Meta',
                    'route' => 'admin.settings.meta.index',
                    'access' => 'module.settings.meta-tag.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
            ]
        ],
        [
            'uniqid' => 'menuPrivacyPolicy',
            'type' => 'menu',
            'text' => 'Privacy Policy',
            'route' => 'admin.privacy-policy.index',
            'access' => 'module.privacy-policy.index',
            'active' => false,
            'open' => false,
            'children' => null
        ],
        [
            'uniqid' => 'menuLogActivity',
            'type' => 'menu',
            'text' => 'Log Activity',
            'route' => 'admin.log-activity.index',
            'access' => 'module.log-activity.index',
            'active' => false,
            'open' => false,
            'children' => null
        ]
    ]
];
