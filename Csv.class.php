<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Csv
 *
 * @author matt huang
 * @usage $csv = new Csv('$PATH');
 */
class Csv implements IteratorAggregate{
    //put your code here
    protected $_filename;
    
    public function __construct($filename)
    {
        $this->_filename = $filename;
    }
    public function getIterator()
    {
        $file = new SplFileObject($this->_filename, 'r');
        $file->fgetcsv("\t");
        return $file;
    }
}
