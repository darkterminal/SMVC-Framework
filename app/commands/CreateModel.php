<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle as OutputFormatterStyle;

class CreateModel extends Command
{
    protected $commandName = 'make:model';
    protected $commandDescription = "Created your model to your application.";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Created your model using command on this application";

    protected $commandOptionName = "o"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will create fillabel default Eloquent';    

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

            $modelName = 'app/models/'.$pagename.".php";
            $newFileContent = <<<EOD
<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class $name extends Eloquent {
    
    // TODO Define model fillable Eloquent
    # code...

}
EOD;

            if (!file_exists($modelName)) {

                function make_path($modelName)
                {
                    $dir = pathinfo($modelName , PATHINFO_DIRNAME);
                    
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
                make_path($modelName);
                if (file_put_contents($modelName, $newFileContent, FILE_APPEND) !== false) {
                    $text = "File created (" . basename($modelName) . ") in app/models/".$pagename.".php";
                } else {
                    $text = "Cannot create file (" . basename($modelName) . ")";
                }

            }else{
                $text = "File exists in models";
            }

        } else {
            $text = <<<EOD
Please give a parameter to controller name!

    $ php artisan make:model <name>

EOD;
        }

        if ($input->getOption($this->commandOptionName)) {
            $text = $text;
        }

        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln('<fire>'.$text.'</fire>');
    }
}