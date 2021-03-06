<?php

/**
 * Created by vatgia-framework.
 * Date: 7/7/2017
 * Time: 10:32 AM
 */
class ModelUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function setUp()
    {
        //Change mysql config
        $config = config('database');
        $config['host'] = 'localhost:6604';
        $config['slave']['host'] = 'localhost:6604';
        app('config')->set('database', $config);

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testUpdateWithRawData()
    {

        $user = \App\Models\Users\Users::findByID(88);

        $emailCheck = $user->email + 1;

        $user->update(['use_email' => db_raw('use_email + 1')]);

        $this->assertEquals($emailCheck, $user->email);
    }
}