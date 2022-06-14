<?php

class Auth
{
    public static function getUserToken($user)
    {
        $res = (new DB())->getArrayFromQuery(
            'SELECT id FROM users WHERE name = ' . $user['name'] . 'and password =' . md5($user['password'])
        );
        if(count($res) > 0)
        {
            $id = $res[0]['id'];
            $token = substr(bin2hex(random_bytes(64)),0,100);

            $res2 = (new DB)->runQuery('UPDATE users SET token WHERE id =' . $id);
            if($res2)
            {
                return ['token' => $token];
            }
        }
        return ['error' => 'Username or password is not correct'];
    }

    public static function checkToken($token)
    {
        $res = (new DB())->getArrayFromQuery('SELECT id FROM users WHERE token = ' . $token);

        if(count($res)>0)
        {
            return true;
        }
        return  false;
    }
}