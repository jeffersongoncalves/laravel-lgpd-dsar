<?php

return [

    'table' => 'lgpd_dsar_requests',

    /*
     * Days to answer a request in full (LGPD art. 19, II: 15 days).
     * Small processing agents may double it (ANPD Res. 2/2022, art. 14).
     */
    'deadline_days' => 15,

    /*
     * Where exports (JSON, art. 18 II/V) are written. Keep it a private disk:
     * the file holds the data subject's personal data.
     */
    'disk' => 'local',
    'directory' => 'lgpd/dsar',

];
