<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Tools\CURL;
class ToolsCurlProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('CURL', function () {
        return new CURL;
    });
}
}
?>