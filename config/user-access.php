<?php

return [
    'access' => [
        [
            'module' => 'Homepage',
            'sub_module' => [
                [
                    'module' => 'Sliding Banner',
                    'activities' => [
                        [
                            'label' => 'Menu Sliding Banner',
                            'value' => 'module.homepage.sliding-banner.index',
                        ],
                        [
                            'label' => 'Create Sliding Banner',
                            'value' => 'module.homepage.sliding-banner.create',
                        ],
                        [
                            'label' => 'Edit Sliding Banner',
                            'value' => 'module.homepage.sliding-banner.edit',
                        ],
                        [
                            'label' => 'Delete Sliding Banner',
                            'value' => 'module.homepage.sliding-banner.delete',
                        ]
                    ]
                ],
                [
                    'module' => 'Introduction',
                    'activities' => [
                        [
                            'label' => 'Menu Home Introduction',
                            'value' => 'module.homepage.home-about.index',
                        ],
                        [
                            'label' => 'Create Home Introduction',
                            'value' => 'module.homepage.home-about.create',
                        ],
                        [
                            'label' => 'Edit Home Introduction',
                            'value' => 'module.homepage.home-about.edit',
                        ],
                    ]
                ],
                [
                    'module' => 'Supported By',
                    'activities' => [
                        [
                            'label' => 'Menu Supported By',
                            'value' => 'module.homepage.supported-by.index',
                        ],
                        [
                            'label' => 'Create Supported By',
                            'value' => 'module.homepage.supported-by.create',
                        ],
                        [
                            'label' => 'Edit Supported By',
                            'value' => 'module.homepage.supported-by.edit',
                        ],
                        [
                            'label' => 'Delete Supported By',
                            'value' => 'module.homepage.supported-by.delete',
                        ]
                    ]
                ],
            ]
        ],
        [
            'module' => 'About Us',
            'sub_module' => [
                [
                    'module' => 'Our History',
                    'activities' => [
                        [
                            'label' => 'Menu Our History',
                            'value' => 'module.about-us.history.index',
                        ],
                        [
                            'label' => 'Create Our History',
                            'value' => 'module.about-us.history.create',
                        ],
                        [
                            'label' => 'Edit Our History',
                            'value' => 'module.about-us.history.edit',
                        ],
                        [
                            'label' => 'Delete Our History',
                            'value' => 'module.about-us.history.delete',
                        ]
                    ]
                ],
            ]
        ],
        [
            'module' => 'Settings (Master Data)',
            'sub_module' => [
                [
                    'module' => 'Group User',
                    'activities' => [
                        [
                            'label' => 'Menu Group User',
                            'value' => 'module.settings.jabatan.index',
                        ],
                        [
                            'label' => 'Create Group User',
                            'value' => 'module.settings.jabatan.create',
                        ],
                        [
                            'label' => 'Edit Group User',
                            'value' => 'module.settings.jabatan.edit',
                        ],
                        [
                            'label' => 'Delete Group User',
                            'value' => 'module.settings.jabatan.delete',
                        ]
                    ]
                ],
                [
                    'module' => 'User',
                    'activities' => [
                        [
                            'label' => 'Menu User',
                            'value' => 'module.settings.karyawan.index',
                        ],
                        [
                            'label' => 'Create User',
                            'value' => 'module.settings.karyawan.create',
                        ],
                        [
                            'label' => 'Edit User',
                            'value' => 'module.settings.karyawan.edit',
                        ],
                        [
                            'label' => 'Delete User',
                            'value' => 'module.settings.karyawan.delete',
                        ]
                    ]
                ],
                [
                    'module' => 'Meta Tag',
                    'activities' => [
                        [
                            'label' => 'Menu Meta Tag',
                            'value' => 'module.settings.meta-tag.index',
                        ],
                        [
                            'label' => 'Create Meta Tag',
                            'value' => 'module.settings.meta-tag.create',
                        ],
                        [
                            'label' => 'Edit Meta Tag',
                            'value' => 'module.settings.meta-tag.edit',
                        ],
                        [
                            'label' => 'Delete Meta Tag',
                            'value' => 'module.settings.meta-tag.delete',
                        ]
                    ]
                ],
            ]
        ],
        [
            'module' => 'Privacy Policy',
            'sub_module' => [
                [
                    'module' => 'Privacy Policy',
                    'activities' => [
                        [
                            'label' => 'Menu Privacy Policy',
                            'value' => 'module.privacy-policy.index',
                        ],
                        [
                            'label' => 'Create Privacy Policy',
                            'value' => 'module.privacy-policy.create',
                        ],
                        [
                            'label' => 'Edit Privacy Policy',
                            'value' => 'module.privacy-policy.edit',
                        ],
                    ]
                ]
            ]
        ],
        [
            'module' => 'Log',
            'sub_module' => [
                [
                    'module' => 'Log Activity',
                    'activities' => [
                        [
                            'label' => 'Menu Log Activity',
                            'value' => 'module.log-activity.index',
                        ],
                        [
                            'label' => 'Detail Log Activity',
                            'value' => 'module.log-activity.detail',
                        ]
                    ]
                ]
            ]
        ],
    ]
];
