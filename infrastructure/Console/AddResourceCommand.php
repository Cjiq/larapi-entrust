<?php

namespace Infrastructure\Console;

use Illuminate\Console\Command;

class AddResourceCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'resource:add
                          {name : name of resource}
                          {folder : namespace folder e.g. Core}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Add a new resource to the application.
                            The action will create a Model, Controller,
                            Service and Repository for the new resource.';

  /**
   * User repository to persist user in database
   *
   * @var UserRepository
   */
  protected $userRepository;

  /**
   * Create a new command instance.
   *
   * @param  UserRepository  $userRepository
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  private $modelPath;
  private $controllerPath;
  private $servicePath;
  private $repositoryPath;

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $name = $this->argument('name');
    $folder = $this->argument('folder');
    $folderPath = "api/" . $folder;

    if($this->confirm(sprintf('Are you using the standard larapi folder structure? Otherwise this will not work.', $name, $folderPath)))
    {
      $this->setupPaths($name, $folderPath);
      $this->setupNamespace($name, $foler);

      if(!$this->resourceExists($name, $folderPath))
      {
        $this->createModel($name, $folder);
        $this->createController();
        $this->createService();
        $this->createRepository();

        $this->info(sprintf("The resource '%s' was created at '%s'", $name, $folderPath));
      }
    }
  }

  private function resourceExists($name, $folderPath)
  {
    $location = base_path() . '/' . $folderPath;
    $error_def = "Resource creation failed: ";
    if(file_exists($this->modelPath))
    {
      $this->error($error_def . 'Model already exists. Aborting..');
      return true;
    }
    if(file_exists($this->controllerPath))
    {
      $this->error($error_def . 'Controller already exists. Aborting..');
      return true;
    }
    if(file_exists($this->servicePath))
    {
      $this->error($error_def . 'Service already exists. Aborting..');
      return true;
    }
    if(file_exists($this->repositoryPath))
    {
      $this->error($error_def . 'Repository already exists. Aborting..');
      return true;
    }
    return false;
  }

  private function setupPaths($name, $folderPath)
  {
    $base = base_path() . '/' . $folderPath;

    $this->modelPath = $base . '/Models/' . $name . '.php';
    $this->controllerPath = $base . '/Controllers/' . $name . 'Controller.php';
    $this->servicePath = $base . '/Services/' . $name . 'Service.php';
    $this->repositoryPath = $base . '/Repositories/' . $name . 'Repository.php';
  }

  private function createModel($name, $folder)
  {
    $content =
      '<?php
namespace Api\\' . $folder . '\Models;

    use Infrastructure\Database\Eloquent\Model;

    class ' . $name . ' extends Model
    {
      protected $table = "' . $name . '";
      
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
      ];
      
      /**
       * The attributes that should be hidden for arrays.
       *
       * @var array
       */
      protected $hidden = [
      ];

    }';
    print_r($content);
  }

  function file_force_contents($dir, $contents){
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
    foreach($parts as $part)
    if(!is_dir($dir .= "/$part")) mkdir($dir);
    file_put_contents("$dir/$file", $contents);
  }
}
