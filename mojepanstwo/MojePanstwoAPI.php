<?php

namespace daweb\mojepanstwo;

/**
 * Basic functionality of the service api
 *
 * Description API https://mojepanstwo.pl/api/technical_info
 * @author Dawid Bednarz <dawid@daweb.vdl.pl>
 * @copyright (c) Jun 9, 2015, Dawid Bednarz <dawid@daweb.vdl.pl>
 * @license BSD-3-Clause
 */
class MojePanstwoAPI {

    const APIUrl = 'http://api.mojepanstwo.pl/';
    const KRS_OSOBY = 0;
    const KRS_OSOBY_FIELDS = 1;
    const KRS_OSOBY_SWITCHERS = 2;
    const KRS_OSOBY_SORTINGS = 3;
    //podmioty
    const KRS_PODMIOTY = 4;
    const KRS_PODMIOTY_FIELDS = 5;
    const KRS_PODMIOTY_SWITCHERS = 6;
    const KRS_PODMIOTY_SORTINGS = 7;

    protected $allowedRoute = [
        //osoby
        'krs/osoby',
        'krs/osoby/fields',
        'krs/osoby/switchers',
        'krs/osoby/sortings',
        //podmioty
        'krs/podmioty',
        'krs/podmioty/fields',
        'krs/podmioty/switchers',
        'krs/podmioty/sortings'
    ];

    public function getRoute($num) {

        if (isset($this->allowedRoute[$num]))
            return $this->allowedRoute[$num];
        return null;
    }

}
