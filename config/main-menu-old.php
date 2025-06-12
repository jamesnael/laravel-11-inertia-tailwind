<?php

return [
    'menu' => [
        [
            'uniqid' => 'menuDashboard', // unique identifier, use route name without function name like index, create, etc
            'type' => 'menu', // menu type "menu" or "divider"
            'text' => 'Dashboard', // menu label
            'route' => 'admin.dashboard.index', // menu url use route() helper
            'access' => true, // user access name, bypass it with true
            'active' => false, // required for helper change if menu active or not
            'open' => false, // required for helper change if submenu must be shown or not
            'children' => null // all sub menu, accept array of object like menu
        ],
        [
            'type' => 'divider',
        ],
        [
            'uniqid' => 'menuMasterData',
            'type' => 'menu',
            'text' => 'Master Data',
            'route' => '#',
            'access' => [
                'module.data-master.jabatan.index',
                'module.data-master.karyawan.index',
                'module.data-master.banner.index',
                'module.data-master.kategori.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'masterBanner',
                    'type' => 'menu',
                    'text' => 'Banner',
                    'route' => 'admin.data-master.banner.index',
                    'access' => 'module.data-master.banner.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterGroupUser',
                    'type' => 'menu',
                    'text' => 'Group User',
                    'route' => 'admin.data-master.jabatan.index',
                    'access' => 'module.data-master.jabatan.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterUser',
                    'type' => 'menu',
                    'text' => 'User',
                    'route' => 'admin.data-master.karyawan.index',
                    'access' => 'module.data-master.karyawan.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterKategori',
                    'type' => 'menu',
                    'text' => 'Category',
                    'route' => 'admin.data-master.kategori.index',
                    'access' => 'module.data-master.kategori.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterNewsTag',
                    'type' => 'menu',
                    'text' => 'Tagging',
                    'route' => 'admin.data-master.news-tag.index',
                    'access' => 'module.data-master.news-tag.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterPrivateSectorPlatform',
                    'type' => 'menu',
                    'text' => 'Pvt. Sector Platform Tag',
                    'route' => 'admin.data-master.private-sector-platform-tag.index',
                    'access' => 'module.data-master.private-sector-platform-tag.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterCountry',
                    'type' => 'menu',
                    'text' => 'Countries',
                    'route' => 'admin.data-master.country.index',
                    'access' => 'module.data-master.country.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterSubject',
                    'type' => 'menu',
                    'text' => 'Subjects',
                    'route' => 'admin.data-master.subject.index',
                    'access' => 'module.data-master.subject.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterPrivacyPoliciy',
                    'type' => 'menu',
                    'text' => 'Privacy Policies',
                    'route' => 'admin.data-master.privacy-policy.index',
                    'access' => 'module.data-master.privacy-policy.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterTermAndUse',
                    'type' => 'menu',
                    'text' => 'Term & Use',
                    'route' => 'admin.data-master.term-use.index',
                    'access' => 'module.data-master.term-use.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterPartnerLogo',
                    'type' => 'menu',
                    'text' => 'Partner Logo',
                    'route' => 'admin.data-master.partner-logo.index',
                    'access' => 'module.data-master.partner-logo.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'masterAuthor',
                    'type' => 'menu',
                    'text' => 'Author',
                    'route' => 'admin.data-master.author.index',
                    'access' => 'module.data-master.author.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ]
            ]
        ],
        [
            'uniqid' => 'menuAboutUs',
            'type' => 'menu',
            'text' => 'About Us',
            'route' => '#',
            'access' => [
                'module.about-us.rkcmpd.index',
                'module.about-us.our-expert.index',
                'module.about-us.background.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                // [
                //     'uniqid' => 'rkcmpd',
                //     'type' => 'menu',
                //     'text' => 'RKC-MPD',
                //     'route' => 'admin.about-us.rkcmpd.index',
                //     'access' => 'module.about-us.rkcmpd.index',
                //     'active' => false,
                //     'open' => false,
                //     'children' => null
                // ],
                // [
                //     'uniqid' => 'background',
                //     'type' => 'menu',
                //     'text' => 'Background',
                //     'route' => 'admin.about-us.background.index',
                //     'access' => 'module.about-us.background.index',
                //     'active' => false,
                //     'open' => false,
                //     'children' => null
                // ],
                [
                    'uniqid' => 'who-we-are',
                    'type' => 'menu',
                    'text' => 'About Us',
                    'route' => 'admin.about-us.who-we-are.index',
                    'access' => 'module.about-us.who-we-are.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'our-project',
                    'type' => 'menu',
                    'text' => 'Our Project',
                    'route' => 'admin.about-us.our-project.index',
                    'access' => 'module.about-us.our-project.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'our-teams',
                    'type' => 'menu',
                    'text' => 'Our Teams',
                    'route' => 'admin.about-us.our-expert.index',
                    'access' => 'module.about-us.our-expert.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'contact-us',
                    'type' => 'menu',
                    'text' => 'Contact Us',
                    'route' => 'admin.about-us.contact-us.index',
                    'access' => 'module.about-us.contact-us.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
            ]
        ],
        [
            'type' => 'divider',
        ],
        [
            'uniqid' => 'menuNews',
            'type' => 'menu',
            'text' => 'Updates',
            'route' => '#',
            'access' => [
                'module.updates.news.index',
                'module.updates.event.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'events',
                    'type' => 'menu',
                    'text' => 'Events',
                    'route' => 'admin.updates.event.index',
                    'access' => 'module.updates.event.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'news',
                    'type' => 'menu',
                    'text' => 'News',
                    'route' => 'admin.updates.news.index',
                    'access' => 'module.updates.news.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ]
            ]
        ],
        [
            'type' => 'divider',
        ],
        [
            'uniqid' => 'menuScientific',
            'type' => 'menu',
            'text' => 'Scientific Information',
            'route' => '#',
            'access' => [
                'module.scientific-information.research-catalogue.index',
                'module.scientific-information.plastic.index',
                'module.scientific-information.lifecycle-assessment.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'researchCatalogue',
                    'type' => 'menu',
                    'text' => 'Research Catalogue',
                    'route' => 'admin.scientific-information.research-catalogue.index',
                    'access' => 'module.scientific-information.research-catalogue.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'lifecycleAssessment',
                    'type' => 'menu',
                    'text' => 'Lifecycle Assessmennt',
                    'route' => 'admin.scientific-information.lifecycle-assessment.index',
                    'access' => 'module.scientific-information.lifecycle-assessment.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'plastic',
                    'type' => 'menu',
                    'text' => 'Plastic & Mangrove',
                    'route' => 'admin.scientific-information.plastic.index',
                    'access' => 'module.scientific-information.plastic.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
            ]
        ],
        [
            'type' => 'divider',
        ],
        [
            'uniqid' => 'menuGovernmentActions',
            'type' => 'menu',
            'text' => 'Government Action',
            'route' => '#',
            'access' => [
                'module.government-action.laws-regulation.index',
                'module.government-action.international-agreement.index',
                'module.government-action.practical-measure.index'
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid' => 'lawsAndRegulation',
                    'type' => 'menu',
                    'text' => 'Laws & Regulations',
                    'route' => 'admin.government-action.laws-regulation.index',
                    'access' => 'module.government-action.laws-regulation.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'internationalAgreement',
                    'type' => 'menu',
                    'text' => 'International Agreement',
                    'route' => 'admin.government-action.international-agreement.index',
                    'access' => 'module.government-action.international-agreement.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
                [
                    'uniqid' => 'practicalMeasures',
                    'type' => 'menu',
                    'text' => 'Practical Measures',
                    'route' => 'admin.government-action.practical-measure.index',
                    'access' => 'module.government-action.practical-measure.index',
                    'active' => false,
                    'open' => false,
                    'children' => null
                ],
            ]
        ],
        [
            'uniqid' => 'menuNonGovernmentActions',
            'type' => 'menu',
            'text' => 'Non Government Actions',
            'route' => 'admin.non-government-action.index',
            'access' => 'module.non-government-action.index',
            'active' => false,
            'open' => false,
            'children' => null
        ],
        [
            'uniqid' => 'menuKnowledgeProduct',
            'type' => 'menu',
            'text' => 'Knowledge Products',
            'route' => '#',
            'access' => [
                'module.knowledge-product.publication.index',
                'module.knowledge-product.zero-on-plastic.index',
            ],
            'active' => false,
            'open' => false,
            'children' => [
                [
                    'uniqid'    => 'publications',
                    'type'      => 'menu',
                    'text'      => 'Reports & Publications',
                    'route'     => 'admin.knowledge-product.publication.index',
                    'access'    => 'module.knowledge-product.publication.index',
                    'active'    => false,
                    'open'      => false,
                    'children'  => null
                ],
                [
                    'uniqid'    => 'zeroOnPlastic',
                    'type'      => 'menu',
                    'text'      => 'Zero-in On Plastic',
                    'route'     => 'admin.knowledge-product.zero-on-plastic.index',
                    'access'    => 'module.knowledge-product.zero-on-plastic.index',
                    'active'    => false,
                    'open'      => false,
                    'children'  => null
                ],
            ]
        ],
        [
            'uniqid' => 'registrationUser',
            'type' => 'menu',
            'text' => 'Registration User',
            'route' => 'admin.registration-user.index',
            'access' => 'module.registration-user.index',
            'active' => false,
            'open' => false,
            'children' => null
        ],
        [
            'uniqid' => 'privateSectorUser',
            'type' => 'menu',
            'text' => 'Product',
            'route' => 'user.product.index',
            'access' => 'module.user.product.index',
            'active' => false,
            'open' => false,
            'children' => null
        ],
        [
            'uniqid' => 'privateSectorAdmin',
            'type' => 'menu',
            'text' => 'Private Sector Product',
            'route' => 'admin.private-sector-product.index',
            'access' => 'module.admin.private-sector-product.index',
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
