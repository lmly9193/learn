<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Casts\Json;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Json::encodeUsing(fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE));

        $this->bootMacros();
        $this->bootBladeDirectives();
    }

    /**
     * Boot macros.
     */
    private function bootMacros(): void
    {
        $mixins = [
            \Illuminate\Database\Schema\Blueprint::class    => \App\Mixins\BlueprintMixin::class,
            \Illuminate\Filesystem\FilesystemAdapter::class => \App\Mixins\FilesystemAdapterMixin::class,
            \Illuminate\Http\Response::class                => \App\Mixins\ResponseMixin::class,
            \Illuminate\Http\UploadedFile::class            => \App\Mixins\UploadedFileMixin::class,
            \Illuminate\Support\Collection::class           => \App\Mixins\CollectionMixin::class,
            \Illuminate\Support\Str::class                  => \App\Mixins\StrMixin::class,
            \Illuminate\Support\Stringable::class           => \App\Mixins\StringableMixin::class,
        ];

        foreach ($mixins as $macroable => $mixin) {
            $macroable::mixin(new $mixin, false);
        }
    }

    /**
     * Boot blade directives.
     */
    private function bootBladeDirectives(): void
    {
        $directives = [
            'money' => fn (int|float $money): string => "<?php echo '$ ' . number_format($money, 0); ?>",
        ];

        foreach ($directives as $name => $handler) {
            \Illuminate\Support\Facades\Blade::directive($name, $handler);
        }
    }
}
