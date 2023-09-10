$(document).ready(function () {
	if ( $(".host-page").length ) {

		console.log('You are on the host-info.php page');

		let pathname = window.location.pathname;
		let location = window.location;
		let host = window.location.host;
		let origin = window.location.origin;

		// checks if the pathname is equal to /demos/host-info.php
		if (pathname === "/demos/host-info.php"){
			console.log('the pathname: ', pathname);
			console.log('the location: ', location);
			console.log('the host: ', host);
			console.log('the origin: ', origin);
		} else {
			console.log('You are NOT on the host-info.php page');
		}

		// This is displayed on the /demos/host-info.php page
		if ($("#host-info").length){
			$("<div>Pathnames: " + pathname + "</div>").appendTo("#host-info");
			$("<div>Location: " + location + "</div>").appendTo("#host-info");
			$("<div>Host: " + host + "</div>").appendTo("#host-info");
			$("<div>Origin: " + origin + "</div>").appendTo("#host-info");
		}
	}
});
