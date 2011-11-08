<?php

/*
* This file is part of the OpenSocialBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace l3l0\Bundle\OpenSocialBundle\Tests\Security\Authentication\Token;

use l3l0\Bundle\OpenSocialBundle\Security\Authentication\Token\FriendConnectToken;

class FriendConnectTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testThatIsAutenticatedForNotEmptyToken()
    {
        $token = new FriendConnectToken('notEmptyToken');

        $this->assertTrue($token->isAuthenticated());
    }

    public function testThatIsNotAutenticatedForEmptyToken()
    {
        $token = new FriendConnectToken('');

        $this->assertFalse($token->isAuthenticated());
    }

    public function testThatCredentialsIsEmpty()
    {
        $token = new FriendConnectToken('notEmptyToken');

        $this->assertEmpty($token->getCredentials());
    }

    public function testThatTokenIsSetAsUser()
    {
        $token = new FriendConnectToken('notEmptyToken');

        $this->assertEquals('notEmptyToken', $token->getFcAuthToken());
    }
}
