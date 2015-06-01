<?php
/**
 * Created by PhpStorm.
 * User: takahashi
 * Date: 2015/05/31
 * Time: 14:00
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
//use App\Model\Title;

class TitleController extends Controller {

    use TraitApiController;

    public function getAll()
    {
        $result = DB::select('SELECT * FROM title');
        return response()->json([
            'status' => 'ok',
            'result' => $result,
        ]);
    }

    public function info($id)
    {
        $result = DB::table('title')->find($id);
        return response()->json([
            'status' => 'ok',
            'result' => $result,
        ]);
    }

    public function token($id)
    {
        $result = DB::table('title')->find($id);
        return response()->json([
            'status' => 'ok',
            'token' => $result->access_token,
        ]);
    }
}