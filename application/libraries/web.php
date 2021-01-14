<?php

/*
 * To change this template, choose Tools | templates
 * and open the template in the editor.
 */

final Class Web
{
    public function _generateURL($date, $title)
    {

        $data = Tanggal::fieldDate($date) . '/' . preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', str_replace(' ', '-', $title));
        $data = str_replace(' ', '', $data);
        return $data;
    }
}
