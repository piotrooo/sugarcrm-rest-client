<?php
namespace Tests\MockSugarServer\Action;

use Ouzo\Utilities\Arrays;
use stdClass;

class Login extends BaseAction
{
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
            $response->id = $user->id;
            $this->response = $response;
        }
        return $this;
    }
}
