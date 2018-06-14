<?php

namespace Phals\Command;

use Composer\Util\Filesystem;
use Phals\Config;
use Phals\Application;
use Phals\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class Create extends Command
{
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('You can create a class in the right folder')
            ->addArgument('fully-qualified-name', InputArgument::REQUIRED, 'The fully qualified name of the class you want to create')
            ->addOption('description', null, InputArgument::OPTIONAL, 'The description of the class')
            ->addOption('interface', null, InputOption::VALUE_NONE, 'This class is an interface')
            ->addOption('abstract', null, InputOption::VALUE_NONE, 'This class should be abstract')
            ->addOption('final', null, InputOption::VALUE_NONE, 'This class should be final')
            ->addOption('as-string', null, InputOption::VALUE_NONE, 'Output/return the class syntax')
            ->addOption('implements',null,InputOption::VALUE_OPTIONAL,'The interface of the class')
            ->addOption('extends',null,InputOption::VALUE_OPTIONAL,'The parent of the class');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Phals\Exception\AbstractInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input_class = $input->getArgument('fully-qualified-name');
        $input_description = $input->getOption('description');

        $option =  new Option($input->getOptions());
        $template = new Application(
            $input_class,
            $option
        );
        $template->setDescription($input_description);

        $file = $this->createFolder($input_class, $this->findVendorFolder() . '/../src/');
        $source = $template->getSourceCode();
        if ($input->getOption('as-string')) {
            $output->write($source);
        } else {

            file_put_contents($file, $source);
            $output->writeln("<info>{$input_class} has been created</info>");
        }
    }

    /**
     * @return string
     * @throws \Exception
     * @internal param $composerConfig
     */
    private function findVendorFolder(): string
    {

        $vendor_dir = $this->getComposer(true, null)->getConfig()->get('vendor-dir');
        $composerConfig = new Config($vendor_dir . '/../');
        $loader = $this->getComposer(true, null)
            ->getAutoloadGenerator()->createLoader($composerConfig->getAutoload());
        $loader->register();
        return $vendor_dir;
    }

    /**
     * Create the folder/file and return this path for the php file.
     * @param $input_class
     * @param $src
     * @return string
     */
    private function createFolder(string $input_class, string $src): string
    {
        $location = explode("\\", $input_class);
        $className = $location[count($location) - 1];

        unset($location[count($location) - 1]);

        $filesystem = new Filesystem();

        $path = implode('/', $location);
        $full_path = $src . $path;
        $filesystem->ensureDirectoryExists($full_path);

        return "{$full_path}/{$className}.php";
    }
}