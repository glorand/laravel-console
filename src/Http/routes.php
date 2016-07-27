<?php

Route::group(['prefix' => 'lucid'], function() {

    // UI Navigation Routes
    Route::get('/dashboard', function() {
        return view('lucid::dashboard');
    });

    Route::get('/dashboard/services', function() {
        return view('lucid::services');
        // return view('lucid::mdl-layout');
    });

    Route::get('/dashboard/domains', function() {
        return view('lucid::domains');
    });

    Route::get('/dashboard/features', function() {
        return view('lucid::features');
    });

    // Data Routes
    Route::get('/services', function() {
        return (new Controller)->listServices();
    });

    Route::get('/services/{slug}/features', function($slug) {
        return (new Controller)->listFeatures($slug);
    });

    Route::get('/features/{name}', function($name) {
        return (new Controller)->findFeature($name)->toArray();
    });

    Route::get('/domains', function() {
        return (new Controller)->listDomains();
    });

    Route::get('/domains/{name}/jobs', function($name) {
        return (new Controller)->listJobsInDomain(\Lucid\Console\Str::domain($name));
    });

    Route::get('/jobs/{name}', function($name) {
        return (new Controller)->findJob($name)->toArray();
    });

    Route::post('/jobs', function() {
        // create job
        $title = request()->input('title');
        $domain = request()->input('domain');

        return app(Lucid\Console\Generators\JobGenerator::class)->generate($title, $domain)->toArray();
    });
});

class Controller {
    use Lucid\Console\Finder;
}