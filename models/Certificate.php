<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 28.02.2019
 * Time: 14:04
 */
class Certificate extends ModelTable
{
    const TABLE_NAME = 'certificate';
    const CERT_PATH = 'data/cert/';
    public $safe = array('id', 'name', 'link', 'filename', 'descr');



}