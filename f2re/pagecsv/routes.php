<?php
Route::get('/sitemap_csv.xml', 'F2re\Pagecsv\Controllers\CSVproc@sitemap')->middleware('web');