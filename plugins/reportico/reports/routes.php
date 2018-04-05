<?php 
Route::post('/reportico/ajax', 'Reportico\Reports\Controllers\FrontEnd@ajax')->middleware('web');
Route::get('/reportico/execute/{project}/{report}', 'Reportico\Reports\Controllers\FrontEnd@execute')->middleware('web');
Route::get('/reportico/prepare/{project}/{report}', 'Reportico\Reports\Controllers\FrontEnd@prepare')->middleware('web');
Route::get('/reportico/menu/{project}', 'Reportico\Reports\Controllers\FrontEnd@menu')->middleware('web');
Route::get('/reportico/admin', 'Reportico\Reports\Controllers\FrontEnd@admin')->middleware('web');
Route::get('/reportico', 'Reportico\Reports\Controllers\FrontEnd@reportico')->middleware('web');
?>
