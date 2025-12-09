<?php

return [
  'access' => [
    [
      'module' => 'Dashboard',
      'sub_module' => [
        [
          'module' => 'Dashboard',
          'activities' => [
            [
              'label' => 'Menu Dashboard',
              'value' => 'module.dashboard.index',
            ]
          ]
        ]
      ]
    ],
    [
      'module' => 'Data Master',
      'sub_module' => [
        [
          'module' => 'Role',
          'activities' => [
            [
              'label' => 'Menu Role',
              'value' => 'module.data-master.role.index',
            ],
            [
              'label' => 'Tambah Role',
              'value' => 'module.data-master.role.create',
            ],
            [
              'label' => 'Ubah Role',
              'value' => 'module.data-master.role.edit',
            ],
            [
              'label' => 'Hapus Role',
              'value' => 'module.data-master.role.delete',
            ]
          ]
        ],
        [
          'module' => 'User',
          'activities' => [
            [
              'label' => 'Menu User',
              'value' => 'module.data-master.user.index',
            ],
            [
              'label' => 'Tambah User',
              'value' => 'module.data-master.user.create',
            ],
            [
              'label' => 'Ubah User',
              'value' => 'module.data-master.user.edit',
            ],
            [
              'label' => 'Hapus User',
              'value' => 'module.data-master.user.delete',
            ]
          ]
        ],
      ]
    ],
    [
      'module' => 'Riwayat',
      'sub_module' => [
        [
          'module' => 'Riwayat Aktivitas',
          'activities' => [
            [
              'label' => 'Menu Riwayat Aktivitas',
              'value' => 'module.log-activity.index',
            ],
            [
              'label' => 'Detail Riwayat Aktivitas',
              'value' => 'module.log-activity.detail',
            ]
          ]
        ]
      ]
    ],
  ]
];
