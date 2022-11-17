<?php

require_once("inc/route.php");
define('HEADER_SECURITY', true);

get('/', 'home');
get('/page/$page', 'home');

get('/s/$search_text', 'search');
get('/s/$search_text/page/$page', 'search');

get('/detail/$encrypted_id/$name', 'detail');

// api
get('/api/$api', '/api');
post('/api/$api', '/api');

any('/404','404');
