<?php
namespace BDBulkSMS\LaravelSms;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use BDBulkSMS\LaravelSms\Console\Commands\SendSmsCommand;
use BDBulkSMS\LaravelSms\Console\Commands\SmsLogsCommand;
use BDBulkSMS\LaravelSms\Console\Commands\CleanupSmsLogsCommand;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bdbulksms.php','bdbulksms');
        $this->app->singleton('sms',fn()=>new SmsService());
    }

    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->publishes([__DIR__.'/../config/bdbulksms.php'=>config_path('bdbulksms.php')],'config');
            $this->publishes([__DIR__.'/../database/migrations/'=>database_path('migrations')],'migrations');
            $this->commands([SendSmsCommand::class,SmsLogsCommand::class,CleanupSmsLogsCommand::class]);
        }

        $this->app->booted(function(){
            $schedule=$this->app->make(Schedule::class);
            $schedule->call(function(){
                $days=config('bdbulksms.log_retention_days');
                if(!empty($days) && $days>0){
                    $cutoff=\Illuminate\Support\Carbon::now()->subDays($days);
                    $deleted=\BDBulkSMS\LaravelSms\Models\SmsLog::where('created_at','<',$cutoff)->delete();
                    \Log::info("[BDBulkSMS] Auto-cleaned {$deleted} SMS logs older than {$days} days.");
                }
            })->dailyAt('02:00');
        });
    }
}
