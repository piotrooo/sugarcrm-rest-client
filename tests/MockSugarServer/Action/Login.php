<?php
namespace Tests\MockSugarServer\Action;

use Ouzo\Utilities\Arrays;
use stdClass;

class Login extends BaseAction
{
    private $post;

    public function __construct($post)
    {
        $this->post = $post;
        $this->addDefaultElement(array(
            'id' => '2qlkr4sa14p9s68jh4s92beg17',
            'user_name' => 'admin',
            'password' => md5('123qwe')
        ));
    }

    public function process()
    {
        $post = $this->post;
        $filterLogin = Arrays::filter($this->getElements(), function ($element) use ($post) {
            if ($element->user_name == $post->user_auth->user_name && $element->password == $post->user_auth->password) {
                return $element;
            }
            return null;
        });
        if (!$filterLogin) {
            $response = new stdClass();
            $response->name = 'Invalid Login';
            $response->number = '10';
            $response->description = 'Login attempt failed please check the username and password';
            $this->response = $response;
        } else {
            $user = Arrays::first($filterLogin);
            $response = new stdClass();
            $response->id = $user;
            $this->response = $response;
        }
        return $this;
    }
}
