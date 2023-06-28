<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Training\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('trainings', 'TrainingController');
    Route::resource('trainers', 'TrainerController');
    Route::resource('trainingprograms', 'TrainingProgramController');

    Route::group([
        'as' => 'trainings.',
        'prefix' => 'trainings/{id}'
    ],
    function(){
        
        Route::get('/participants', 'TrainingController@participants')->name('participants');
        Route::post('/actionParticipants', 'TrainingController@actionParticipants')->name('actionParticipants');

        Route::get('/materials', 'TrainingController@getMaterials')->name('getMaterials');
        Route::post('/materials', 'TrainingController@saveMaterials')->name('saveMaterials');
        Route::delete('/materials/{material_id}', 'TrainingController@deleteMaterials')->name('deleteMaterials');

        Route::get('/costs', 'TrainingController@getCosts')->name('getCosts');
        Route::post('/costs', 'TrainingController@saveCosts')->name('saveCosts');
        Route::delete('/costs/{cost_id}', 'TrainingController@deleteCosts')->name('deleteCosts');


        Route::resource('/template', 'TrainingTemplateController');
        Route::get('/evaluation/{template_id}', 'TrainingTemplateController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation/{template_id}', 'TrainingTemplateController@saveEvaluationForm')->name('saveEvaluation');
    });
    Route::get('td/overview', 'TrainingOverviewController@index')->name('td.index');

    Route::get('mytraining', 'MyTrainingController@index')->name('mytrainings.index');
    Route::get('training_calendar', 'MyTrainingController@calendar')->name('mytrainings.calendar');
    Route::group([
        'as' => 'mytrainings.',
        'prefix' => 'mytraining/{id}'
    ],
    function(){
        Route::get('/', 'MyTrainingController@show')->name('show');
        Route::post('/apply_training', 'TrainingController@apply_training')->name('apply');
        
        Route::get('/evaluation', 'MyTrainingController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation', 'MyTrainingController@saveEvaluationForm')->name('saveEvaluation');
        Route::get('/calendar', 'MyTrainingController@getTraining')->name('getTraining');
    });
    
});

Route::group([
    'namespace' => 'Hris\Training\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('trainings', 'TrainingController');
    Route::resource('trainers', 'TrainerController');
    Route::resource('trainingprograms', 'TrainingProgramController');

    Route::group([
        'as' => 'trainings.',
        'prefix' => 'trainings/{id}'
    ],
    function(){
        
        Route::get('/participants', 'TrainingController@participants')->name('participants');
        Route::post('/actionParticipants', 'TrainingController@actionParticipants')->name('actionParticipants');

        Route::get('/materials', 'TrainingController@getMaterials')->name('getMaterials');
        Route::post('/materials', 'TrainingController@saveMaterials')->name('saveMaterials');
        Route::delete('/materials/{material_id}', 'TrainingController@deleteMaterials')->name('deleteMaterials');

        Route::get('/costs', 'TrainingController@getCosts')->name('getCosts');
        Route::post('/costs', 'TrainingController@saveCosts')->name('saveCosts');
        Route::delete('/costs/{cost_id}', 'TrainingController@deleteCosts')->name('deleteCosts');


        Route::resource('/template', 'TrainingTemplateController');
        Route::get('/evaluation/{template_id}', 'TrainingTemplateController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation/{template_id}', 'TrainingTemplateController@saveEvaluationForm')->name('saveEvaluation');
    });
    Route::get('td/overview', 'TrainingOverviewController@index')->name('td.index');

    Route::get('mytraining', 'MyTrainingController@index')->name('mytrainings.index');
    Route::get('training_calendar', 'MyTrainingController@calendar')->name('mytrainings.calendar');
    Route::group([
        'as' => 'mytrainings.',
        'prefix' => 'mytraining/{id}'
    ],
    function(){
        Route::get('/', 'MyTrainingController@show')->name('show');
        Route::post('/apply_training', 'TrainingController@apply_training')->name('apply');
        
        Route::get('/evaluation', 'MyTrainingController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation', 'MyTrainingController@saveEvaluationForm')->name('saveEvaluation');
        Route::get('/calendar', 'MyTrainingController@getTraining')->name('getTraining');
    });

});

Route::group([
    'namespace' => 'Hris\Training\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('trainings', 'TrainingController');
    Route::resource('trainers', 'TrainerController');
    Route::resource('trainingprograms', 'TrainingProgramController');

    Route::group([
        'as' => 'trainings.',
        'prefix' => 'trainings/{id}'
    ],
    function(){
        
        Route::get('/participants', 'TrainingController@participants')->name('participants');
        Route::post('/actionParticipants', 'TrainingController@actionParticipants')->name('actionParticipants');

        Route::get('/materials', 'TrainingController@getMaterials')->name('getMaterials');
        Route::post('/materials', 'TrainingController@saveMaterials')->name('saveMaterials');
        Route::delete('/materials/{material_id}', 'TrainingController@deleteMaterials')->name('deleteMaterials');

        Route::get('/costs', 'TrainingController@getCosts')->name('getCosts');
        Route::post('/costs', 'TrainingController@saveCosts')->name('saveCosts');
        Route::delete('/costs/{cost_id}', 'TrainingController@deleteCosts')->name('deleteCosts');


        Route::resource('/template', 'TrainingTemplateController');
        Route::get('/evaluation/{template_id}', 'TrainingTemplateController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation/{template_id}', 'TrainingTemplateController@saveEvaluationForm')->name('saveEvaluation');
    });
    Route::get('td/overview', 'TrainingOverviewController@index')->name('td.index');

    Route::get('mytraining', 'MyTrainingController@index')->name('mytrainings.index');
    Route::get('training_calendar', 'MyTrainingController@calendar')->name('mytrainings.calendar');
    Route::group([
        'as' => 'mytrainings.',
        'prefix' => 'mytraining/{id}'
    ],
    function(){
        Route::get('/', 'MyTrainingController@show')->name('show');
        Route::post('/apply_training', 'TrainingController@apply_training')->name('apply');
        
        Route::get('/evaluation', 'MyTrainingController@evaluationForm')->name('getEvaluation');
        Route::post('/evaluation', 'MyTrainingController@saveEvaluationForm')->name('saveEvaluation');
        Route::get('/calendar', 'MyTrainingController@getTraining')->name('getTraining');
    });
    
});