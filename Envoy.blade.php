{{--@servers(['web' => 'root@162.243.29.32'])--}}

{{--@task('deploy.production', ['on' => 'web'])--}}
    {{--cd /var/www/earlyscienceinitiative--}}
    {{--git pull origin master--}}
    {{--composer install--}}
{{--@endtask--}}

{{--@task('migrate.production', ['on' => 'web'])--}}
    {{--cd /var/www/earlyscienceinitiative--}}
    {{--php artisan migrate --database={{ $database }} --force--}}
{{--@endtask--}}

{{--@task('refresh.production', ['on' => 'web'])--}}
    {{--cd /var/www/earlyscienceinitiative--}}
    {{--php artisan migrate:refresh --seed --database={{ $database }} --force--}}
{{--@endtask--}}

{{--@task('seed.production', ['on' => 'web'])--}}
    {{--cd /var/www/earlyscienceinitiative--}}
    {{--php artisan db:seed --database={{ $database }} --force--}}
{{--@endtask--}}

{{--@task('oneseed.production', ['on' => 'web'])--}}
{{--cd /var/www/earlyscienceinitiative--}}
{{--php artisan db:seed --class={{$class}} --database={{ $database }} --force--}}
{{--@endtask--}}
