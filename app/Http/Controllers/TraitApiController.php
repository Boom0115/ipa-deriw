<?php
/**
 * Created by PhpStorm.
 * User: takahashi
 * Date: 2015/05/31
 * Time: 19:21
 */

namespace App\Http\Controllers;


trait TraitApiController {
    public function index()
    {
        return response()->json([
            'status' => 'no command',
        ]);
    }
}