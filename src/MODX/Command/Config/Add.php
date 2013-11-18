<?php namespace MODX\Command\Config;

use MODX\Command\BaseCmd;
use Symfony\Component\Console\Input\InputArgument;

class Add extends BaseCmd
{
    protected $name = 'config:add';
    protected $description = 'Add a new modx installation to configuration';

    protected function getArguments()
    {
        return array(
            array(
                'service_class',
                InputArgument::REQUIRED,
                'Your component service class name'
            ),
            array(
                'path',
                InputArgument::OPTIONAL,
                'Your component base path, defaults to current dir',
                getcwd()
            ),
            array(
                'erase',
                InputArgument::OPTIONAL,
                'Whether or not override existing component',
                false
            ),
        );
    }

    protected function process()
    {
        $service = $this->argument('service_class');
        $path = $this->argument('path');
        $erase = $this->argument('erase');

        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        /** @var \MODX\Application $application */
        $application = $this->getApplication();
        // @todo: beware of refactoring
        $original = $application->getCurrentConfig();

        $data = array(
            $service => array(
                'class' => $service,
                'base_path' => $path,
            ),
        );
        $data = array_merge($original, $data);
        ksort($data);

        //$this->writeConfig($data, $input, $output);
        if ($erase || !array_key_exists($service, $original)) {
            $this->writeConfig($data);
        } else {
            $this->error('Entry with that name already in config : '. $service);
        }
    }

    protected function writeConfig(array $data)
    {
        /** @var \MODX\Application $application */
        $application = $this->getApplication();
        if ($application->writeConfig($data)) {
            return $this->info('Config file updated');
        }

        $this->error('Something went wrong while updating the config');
    }
}
