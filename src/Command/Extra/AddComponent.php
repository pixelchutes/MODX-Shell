<?php namespace MODX\Shell\Command\Extra;

use MODX\Shell\Command\BaseCmd;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * A command to register the given service as "command provider"
 */
class AddComponent extends BaseCmd
{
    const MODX = true;

    protected $name = 'extra:component:add';
    protected $description = 'Add the given component service class to the "registered" services, so its defined commands could be loaded/used.';

    protected function process()
    {
        $config = $this->getApplication()->components;
        $service = $this->argument('service');
        $lower = strtolower($service);

        if ($config->get($lower)) {
            $this->info($service .' is already registered');
            return;
        }

        // @TODO: make sure the service is valid & loadable + handle parameters

        $components[$lower] = array(
            'service' => $service,
        );
        $config->set($lower, $components[$lower]);

        $saved = $config->save();
        if ($saved) {
            $this->info($service. ' successfully registered');
            return;
        }

        $this->error('An error occurred when trying to register '. $service .' service');
    }

    protected function getArguments()
    {
        return array(
            array(
                'service',
                InputArgument::REQUIRED,
                'The service class name'
            ),
        );
    }

    protected function getOptions()
    {
        return array(
            array(
                'parameters',
                'p',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'An array of parameters to be sent to the service when instantiated, ie. --parameters=\'key=value\' --parameters=\'another_key=value\''
            ),
        );
    }
}
