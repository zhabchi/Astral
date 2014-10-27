<?php 



include "app/config.php";

include "app/detect.php";



if ($page_name=='') {

	include $browser_t.'/index.html';

	}

elseif ($page_name=='index.html') {

	include $browser_t.'/index.html';

	}

elseif ($page_name=='about.html') {

	include $browser_t.'/about.html';

	}

elseif ($page_name=='service.html') {

	include $browser_t.'/service.html';

	}

elseif ($page_name=='contact.html') {

	include $browser_t.'/contact.html';

	}

elseif ($page_name=='details.html') {

	include $browser_t.'/details.html';

	}
elseif ($page_name=='details_products.html') {

	include $browser_t.'/details_products.html';

	}
elseif ($page_name=='details_activities.html') {

	include $browser_t.'/details_activities.html';

	}
elseif ($page_name=='404.html') {

	include $browser_t.'/404.html';

	}

elseif ($page_name=='contact-post.html') {

	include 'app/contact.php';

	}

else

	{

		include $browser_t.'/404.html';

	}



?>

