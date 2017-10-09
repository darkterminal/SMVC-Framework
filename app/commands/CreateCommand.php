<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle as OutputFormatterStyle;

class CreateCommand extends Command
{
    protected $commandName = 'make:command';
    protected $commandDescription = "Created your own artisan command";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Created your own artisan command on this application";

    protected $commandOptionName = "w"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will greet in CamelCase Letters';    

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addOption(
               $this->commandOptionName,
               null,
               InputOption::VALUE_NONE,
               $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);

        if ($name) {
            
            $pagename = ucwords($name);

            $cmdName = 'app/commands/'.$pagename.".php";
            $newFileContent = <<<EOD
<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle as OutputFormatterStyle;

class $name extends Command
{
    protected \$cmdName = 'app:greet';
    protected \$commandDescription = "Greets Someone";

    protected \$commandArgumentName = "name";
    protected \$commandArgumentDescription = "Who do you want to greet?";

    protected \$commandOptionName = "cap"; // should be specified like "app:greet John --cap"
    protected \$commandOptionDescription = 'If set, it will greet in uppercase letters';    

    protected function configure()
    {
        \$this
            ->setName(\$this->commandName)
            ->setDescription(\$this->commandDescription)
            ->addArgument(
                \$this->commandArgumentName,
                InputArgument::OPTIONAL,
                \$this->commandArgumentDescription
            )
            ->addOption(
                \$this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                \$this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface \$input, OutputInterface \$output)
    {
        \$name = \$input->getArgument(\$this->commandArgumentName);

        if (\$name) {
            \$text = 'Hello '.\$name;
        } else {
            \$text = 'Hello';
        }

        if (\$input->getOption(\$this->commandOptionName)) {
            \$text = strtoupper(\$text);
        }

        \$style = new OutputFormatterStyle('green');
        \$output->getFormatter()->setStyle('fire', \$style);

        \$output->writeln('<fire>'.\$text.'</fire>');
    }
}
EOD;

            if (!file_exists($cmdName)) {

                function make_path($cmdName)
                {
                    $dir = pathinfo($cmdName , PATHINFO_DIRNAME);
                    
                    if( is_dir($dir) )
                    {
                        return true;
                    }
                    else
                    {
                        if( make_path($dir) )
                        {
                            if( mkdir($dir) )
                            {
                                chmod($dir , 0777);
                                return true;
                            }
                        }
                    }
                    
                    return false;
                }
                make_path($cmdName);
                if (file_put_contents($cmdName, $newFileContent, FILE_APPEND) !== false) {
                    $text = "File created (" . basename($cmdName) . ") in app/commands/".$pagename.".php";
                } else {
                    $text = "Cannot create file (" . basename($cmdName) . ")";
                }

            }else{
                $text = "File exists in commands";
            }

        } else {
            $text = <<<EOD
Please give a parameter to controller name!

    $ php artisan make:command <name>

EOD;
        }

        if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }

        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln('<fire>'.$text.'</fire>');
    }
}