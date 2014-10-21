<?php

// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://www.redmine.org/projects.json");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$json_str = curl_exec($ch);


// grab URL and pass it to the browser
//echo '['. curl_exec($ch) . ']';
echo '['. $json_str . ']';

// close cURL resource, and free up system resources
curl_close($ch);

$projects = json_decode($json_str);

echo '['. count($projects) . ']';
echo '['. $projects->projects[0]->name . ']';

$project = $projects->projects;

foreach ($project as $project){
	echo '<p><b>Projeto: '.$project->name.'</b> <br />';
	echo 'Id: '.$project->identifier.'</p>';
}



/*
error_reporting(E_ALL);

require_once ('ActiveResource.php');

class Project extends ActiveResource {
    var $site = 'http://redmine/redmine/';
    var $request_format = 'xml'; // REQUIRED!	
	var $element_name = 'issue';	
	var $request_headers = array("x-api-key: xIQ2IRRATfdEEtmz9Mmc");
}

// find projects
$project = new Project();

$projects = $project->find('all');

echo 'Projetos: '.count($projects);

for ($i=0; $i < count($projects); $i++) {
    echo $projects[$i]->name;
}
*/

?>