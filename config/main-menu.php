<?php

return [
  'menu' => [
    [
      'uniqid' => 'menuDashboard',
      'type' => 'menu',
      'text' => 'Dashboard',
      'route' => 'admin.dashboard.index',
      'access' => 'module.dashboard.index',
      'active' => false,
      'open' => false,
      'children' => null
    ],
    [
      'uniqid' => 'menuMaster',
      'type' => 'menu',
      'text' => 'Data Master',
      'route' => '#',
      'access' => [
        'module.data-master.role.index',
        'module.data-master.user.index'
      ],
      'active' => false,
      'open' => false,
      'children' => [
        [
          'uniqid' => 'masterJabatan',
          'type' => 'menu',
          'text' => 'Role',
          'route' => 'admin.data-master.role.index',
          'access' => 'module.data-master.role.index',
          'active' => false,
          'open' => false,
          'children' => null
        ],
        [
          'uniqid' => 'masterUser',
          'type' => 'menu',
          'text' => 'User',
          'route' => 'admin.data-master.user.index',
          'access' => 'module.data-master.user.index',
          'active' => false,
          'open' => false,
          'children' => null
        ],
      ]
    ],
    [
      'uniqid' => 'menuLogActivity',
      'type' => 'menu',
      'text' => 'Riwayat Aktivitas',
      'route' => 'admin.log-activity.index',
      'access' => 'module.log-activity.index',
      'active' => false,
      'open' => false,
      'children' => null
    ]
  ]
];
