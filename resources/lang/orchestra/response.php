<?php

return [
    'safe-mode' => 'Orchestra Platform is running on safe mode.',

    'account' => [
        'password' => [
            'invalid' => 'Maklumat Kata Laluan Yang Dimasukan Tidak Terdapat Data Simpanan Pangkalan Data.',
            'update'  => 'Kata Laluan Telah Dikemaskini',
        ],
        'profile' => [
            'update' => 'Maklumat Pengguna Telah DIkemaskini',
        ],
    ],

    'credential' => [
        'invalid-combination' => 'Kombinasi Kata Laluan Dan Id Pengguna Tidak Sama.',
        'logged-in'           => 'Berjaya Mendaftar Masuk.',
        'logged-out'          => 'Berjaya Mendaftar Keluar.',
        'unauthorized'        => 'Anda Tidak Dibenarkan Melakukan Tindakan Ini.',
        'register'            => [
            'email-fail'    => 'Emel Pengesahan Pendaftaran Pengguna Gagal Di Hantar.',
            'email-send'    => 'Emel Pengesahan Pendaftaran Pengguna Berjaya Di Hantar.',
            'existing-user' => 'Akaun Emel Ini Telah Di Gunakan.',
        ],
    ],

    'db-failed' => 'Data Gagal Untuk Disimpan Ke Dalam Pangkalan Data',
    'db-404'    => 'Data Tidak Wujud Dalam Pangkalan Data',

    'extensions' => [
        'activate'         => 'Extension :name activated',
        'deactivate'       => 'Extension :name deactivated',
        'configure'        => 'Configuration for Extension :name has been updated',
        'migrate'          => 'Extension :name has been updated',
        'depends-on'       => 'Extension :name was not activated because depends on :dependencies',
        'other-depends-on' => 'Extension :name was not deactivated because :dependencies depends on it',
    ],

    'settings' => [
        'update'        => 'Application settings has been updated',
        'system-update' => 'Orchestra Foundation has been updated',
    ],

    'users' => [
        'create' => 'Maklumat Pengguna Telah Didaftarkan',
        'update' => 'Maklumat Pengguna Telah Dikemaskini',
        'delete' => 'Maklumat Pengguna Telah Dihapuskan',
    ],
];
