<?php

class Controller
{
    private $data;
    private $action;
    private $protectedActions = [
        'get-aquariums',
        'edit-aquarium',
        'del-aquarium',
        'add-aquarium',
        'get-fish'
    ];

    public function __construct()
    {
        $this->action = $_GET['action'];
        $this->data = (array)json_decode(file_get_contents('php://input'), true);
    }

    public function run()
    {
        if(in_array($this->action, $this->protectedActions)
        && !Auth::checkToken($_GET['token']))
        {
            return ['error' => 'auth failed'];
        }

        switch ($this->action)
        {
            case 'login':
                $res = Auth::getUserToken($this->data);
                break;
            case 'get-aquariums':
                $res = Aquarium::getAuqariumList();
                break;
            case 'edit-aquarium':
                if( Aquarium::editAquarium($this->data))
                {
                    $res = ['update' => 'success'];
                } else {
                    $res = ['error' => 'error editing'];
                }
                break;
            case 'del-aquarium':
                if( Aquarium::removeAquarium($this->data))
                {
                    $res = ['delete' => 'success'];
                } else {
                    $res = ['error' => 'error delete'];
                }
                break;
            case 'add-aquarium':
                if( Aquarium::addAquarium($this->data))
                {
                    $res = ['add' => 'success'];
                } else {
                    $res = ['error' => 'error add'];
                }
                break;
            case 'get-fish':
                $res = Aquarium::getFish($this->data);
                break;
            default:
                $res = ['error' => 'this route is undeclared'];
        }
        echo json_decode($res);
    }
}