<?php

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testOne()
    {
        $login = 'Mike';

        $mockPost = [
            'login' => $login,
            'password' => 'qwerty'
        ];

        $request  = new \Framework\Request([], $mockPost);
        $this->assertEquals($login, $request->post('login'));
        $this->assertNull($request->post('unknown_key'));
        $this->assertEquals(123, $request->post('unknown_key', 123));
    }
}