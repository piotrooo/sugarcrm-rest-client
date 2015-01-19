<?php
namespace Tests\MockSugarServer\Action;

class SetEntry extends BaseAction
{
    public function process()
    {
        $sessionId = $this->post->session;
        $this->checkSession($sessionId);

        return $this;
    }
}
