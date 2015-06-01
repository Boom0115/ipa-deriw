<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Aws;
use DB;

class SavedataController extends Controller {

    private $bucket;

    public function __construct()
    {
        $this->bucket = env('BUCKET_NAME');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        abort(404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($user_id, $title_id)
	{
        $s3 = Aws::get('s3');
        $key = $this->getSaveKey($user_id, $title_id);
        $result = [];
        if ($s3->doesObjectExist($this->bucket, $key)) {
            $result['status'] = 'error';
            $result['message'][] = 'Save data already exists.';
        } else {

            $data = [
                'level' => 1,
                'exp' => 0,
                'hp' => 10,
                'atk' => 3,
                'def' => 0,
                'max_hp' => 10,
                'gold' => 0,
                'heal' => 0,
            ];
            $s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'Body' => serialize($data),
            ]);
            $result['status'] = 'ok';
            $result['messages'][] = "Create new save data [{$key}]";
            $result['data'] = $data;
        }

        return response()->json($result);
	}

    /**
     * Delete save data
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {

    }
	/**
	 * load save data
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function load($user_id, $title_id)
	{
        $s3 = Aws::get('s3');
        $key = $this->getSaveKey($user_id, $title_id);
        try {
            $obj = $s3->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $key
            ]);
            $result = [
                'status' => 'ok',
                'messages' => ["Success load data."],
                'data' => unserialize($obj['Body']),
            ];
        } catch (Aws\S3\Exception\NoSuchKeyException $e) {
            $result = [
                'status' => 'error',
                'messages' => ["Failed, data not exists. key:[{$key}]"],
            ];
        }
        return response()->json($result);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function save(Request $request, $user_id, $title_id)
	{
        $s3 = Aws::get('s3');
        $key = $this->getSaveKey($user_id, $title_id);
        $data = $request->input('data', null);
        try {
            $s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'Body' => $data,
            ]);
            $result = [
                'sattus' => 'ok',
                'messages' => ["Success save data [{$key}]"],
            ];
        } catch (Aws\S3\Exception\NoSuchKeyException $e) {
            $result = [
                'status' => 'error',
                'messages' => ["Failed, data not exists. key:[{$key}]"],
            ];
        }
        return response()->json($result);
	}

    private function getSaveKey($user_id, $title_id)
    {
        $title = DB::table('title')->find($title_id);
        $user = DB::table('user')->find($user_id);
        return $user['access_token']. '-' . $title['access_token'];
    }
}
