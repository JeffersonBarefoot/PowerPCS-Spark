<?php

/*
 * Part of the Data Grid Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Data Grid Laravel
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       https://cartalyst.com
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Default Method
    |--------------------------------------------------------------------------
    |
    | Define the default method, this will define the data grid behavior.
    |
    | Supported: "single", "group", "infinite"
    |
    */

    'method' => 'single',

    /*
    |--------------------------------------------------------------------------
    | Threshold
    |--------------------------------------------------------------------------
    |
    | Define the default threshold value.
    |
    | This is the number of results before the pagination begins.
    |
    */

    'threshold' => 100,

    /*
    |--------------------------------------------------------------------------
    | Throttle
    |--------------------------------------------------------------------------
    |
    | Define the default throttle value, which is the maximum results set.
    |
    */

    'throttle' => 100,
];
