<?php

namespace App\Providers;

use App\Resource;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\MessagePolicy;
use App\Policies\VideoPolicy;
use App\Policies\LessonPlanPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\AnnotationPolicy;
use App\Policies\LearningModulePolicy;
use App\Policies\ResourcePolicy;
use App\Policies\UserPolicy;
use App\Message;
use App\Video;
use App\LessonPlan;
use App\Annotation;
use App\Document;
use App\LearningModule;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Message::class => MessagePolicy::class,
        Video::class => VideoPolicy::class,
        LessonPlan::class => LessonPlanPolicy::class,
        Document::class => DocumentPolicy::class,
        Annotation::class => AnnotationPolicy::class,
        LearningModule::class => LearningModulePolicy::class,
        Resource::class => ResourcePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
