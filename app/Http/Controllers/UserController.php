<?php
/**
 * Created by PhpStorm.
 * User: takahashi
 * Date: 2015/05/31
 * Time: 19:06
 */

namespace App\Http\Controllers;
use DB;

class UserController extends Controller {

    use TraitApiController;

    public function getAll()
    {
        $result = DB::select('SELECT * FROM user');
        return response()->json([
            'result' => $result,
        ]);
    }

    public function getToken($id, $secret_key = null)
    {
        $result = DB::table('user')->find($id);
        return response()->json([
            'status'=> 'ok',
            'access-token' => $result->access_token,
        ]);
    }
}