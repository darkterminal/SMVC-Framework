<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle as OutputFormatterStyle;

class GeneratorController extends Command
{
    protected $commandName = 'make:controller';
    protected $commandDescription = "Created Controller for your application";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "This Command will created file controller";

    protected $commandOptionName = "m"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will create models for controller';    

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
            
            $pagename = $name;

            $controllerName = 'app/controllers/'.$pagename.".php";
            $newFileContent = <<<EOD
<?php

class $name extends Controller
{
    public function index()
    {
        // TODO : Define your view page
        # code...
    }
}
EOD;

            if (!file_exists($controllerName)) {

                function make_path($controllerName)
                {
                    $dir = pathinfo($controllerName , PATHINFO_DIRNAME);
                    
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
                make_path($controllerName);
                if (file_put_contents($controllerName, $newFileContent, FILE_APPEND) !== false) {
                    $text = "File created (" . basename($controllerName) . ") in app/controllers/".$pagename.".php";
                } else {
                    $text = "Cannot create file (" . basename($controllerName) . ")";
                }

            }else{
                $text = "File exists in controllers";
            }

        } else {
            $text = <<<EOD
Please give a parameter to controller name!

    $ php artisan app:controller <name>

EOD;
        }

        if ($input->getOption($this->commandOptionName)) {
            
            $modelname = $name.'s';
            
            $modelFile = 'app/models/'.ucfirst($modelname).".php";
            $newFileContent = <<<EOD
<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class $modelname extends Eloquent {

    public \$timestamps = ['created_at','updated_at'];

    protected \$fillable = ['title', 'body','author'];
}
EOD;

            if (!file_exists($modelFile)) {
            
                if (file_put_contents($modelFile, $newFileContent, FILE_APPEND) !== false) {
                    $text = "Controller created Successfully\nModel created Successfully";
                } else {
                    $text = "Cannot create file (" . basename($modelFile) . ")";
                }

            }else{
                $text = "File exists in models";
            }

        }

        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln('<fire>'.$text.'</fire>');
    }
}