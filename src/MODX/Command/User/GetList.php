<?php namespace MODX\Command\User;

use MODX\Command\ListProcessor;

class GetList extends ListProcessor
{
    protected $processor = 'security/user/getlist';
    protected $headers = array(
        'id', 'username', 'active', 'sudo'
    );

    protected $name = 'user:list';
    protected $description = 'List users';

    protected function formatActive($value)
    {
        return $this->renderBoolean($value);
    }

    protected function formatSudo($value)
    {
        return $this->renderBoolean($value);
    }
}
