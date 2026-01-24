<?php
function bulan_romawi($bulan){
    $romawi = [
        1=>'I','II','III','IV','V','VI',
        'VII','VIII','IX','X','XI','XII'
    ];
    return $romawi[(int)$bulan];
}
