<?php namespace MODX\Command\Package\Provider;

use MODX\Command\ListProcessor;

/**
 * List registered package providers
 */
class GetList extends ListProcessor
{
    protected $processor = 'workspace/providers/getlist';
    protected $headers = array(
        'id', 'name', 'service_url'/*, 'description', 'username', 'api_key'*/
    );

    protected $name = 'package:provider:list';
    protected $description = 'List providers';
}
