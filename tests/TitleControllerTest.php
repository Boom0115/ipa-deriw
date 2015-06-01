<?php
/**
 * Created by PhpStorm.
 * User: takahashi
 * Date: 2015/06/01
 * Time: 1:26
 */

//namespace App\Http\Controllers;


class TitleControllerTest extends TestCase {

    public function testGetAllMethodReturnsAllTitlesInfo()
    {
        $response = $this->call('GET', '/title/get-all');
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getContent(), true);
        $this->assertEquals($json['result'][0]['name'], 'game1');
    }

    public function testInfoメソッドでタイトル情報を取得する()
    {
        $response = $this->call('GET', '/title/info/1');
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getContent(), true);
        $this->assertNotNull($json['result']['name'], 'game1');
    }
}
