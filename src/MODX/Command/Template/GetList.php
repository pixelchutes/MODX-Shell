<?php namespace MODX\Command\Template;

use MODX\Command\ListProcessor;

class GetList extends ListProcessor
{
    protected $processor = 'element/template/getlist';
    protected $headers = array(
        'id', 'templatename', 'description', 'category', 'static', 'static_file'
    );

    protected $name = 'template:list';
    protected $description = 'List Templates';

    protected function formatCategory($id)
    {
        return $this->renderObject('modCategory', $id, 'category');
    }

    protected function formatStatic($value)
    {
        return $this->renderBoolean($value);
    }

    protected function formatSource($id)
    {
        return $this->renderObject('modMediaSource', $id, 'name');
    }
}
