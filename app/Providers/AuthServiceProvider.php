<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Chapter;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Content;
use App\Models\Season;
use App\Policies\ContentPolicy;
use App\Policies\CategoryPolicy; 


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       
        Content::class => ContentPolicy::class,
        Rating::class => RatingPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        
    
        $this->registerPolicies();

    }
}
