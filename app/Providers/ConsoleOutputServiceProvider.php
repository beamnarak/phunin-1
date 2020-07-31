class ConsoleOutputServiceProvider extends ServiceProvider
{

 public function register(){
    App::bind('consoleOutput', function(){
        return new \Symfony\Component\Console\Output\ConsoleOutput();
     });
 }