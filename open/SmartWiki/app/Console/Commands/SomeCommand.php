<?php

namespace SmartWiki\Console\Commands;

use Illuminate\Console\Command;

class SomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'some:command {arg1} {--opt1=} {--opt2=default} {--opt3=*} {--O|opt4=} {--opt5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just have a try.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$sp = ' ';
    	
//     	$name = $this->ask('What is your name?');
//     	$this->line($name.$sp);
    	
//     	$arg1 = $this->argument('arg1');
//     	$arguments = $this->argument();
//     	$opt1 = $this->option('opt1');
//     	$options = $this->option();
//     	$this->info($arg1.$sp);
// //     	print_r($arguments);
//     	$this->line($opt1.$sp);
// //     	print_r($options);
    	
//     	$password = $this->secret('What is the password?');
//     	$this->line($password.$sp);
    	
//     	if ($this->confirm('Do you wish to continue?')) {
//     		$this->line('yes');
//     	} else {
//     		$this->line('no');
//     	}
    	
//     	$name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);
//     	$this->line($name);
    	
//     	$name = $this->choice('What is your name?', ['Taylor', 'Dayle'], 1);
//     	$this->line($name);
    	
        $this->error('end');        
    }
}
