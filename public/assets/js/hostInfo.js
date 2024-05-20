$(document).ready(function () {
	if ( $(".host-page").length ) {

		let pathname = window.location.pathname;
		let location = window.location;
		let host = window.location.host;
		let origin = window.location.origin;
		let protocol = window.location.protocol;

		// checks if the pathname is equal to /demos/host-info.php
		if (pathname === "/demos/host-info.php"){
			console.log('the pathname: ', pathname);
			console.log('the location: ', location);
			console.log('the host: ', host);
			console.log('the origin: ', origin);
			console.log('the protocol: ', protocol);
		} else {
			console.log('You are NOT on the host-info.php page');
		}

		// This is displayed on the /demos/host-info.php page
		$("<div>Pathnames: " + pathname + "</div>").appendTo("#host-info");
		$("<div>Location: " + location + "</div>").appendTo("#host-info");
		$("<div>Host: " + host + "</div>").appendTo("#host-info");
		$("<div>Origin: " + origin + "</div>").appendTo("#host-info");
	}
});


(function () {
	let sect = document.getElementsByClassName("host-page-section");
	for (let i = 0; i < sect.length; i++) {
		sect[i].classList.add("border", "border-primary", "rounded", "p-4", "mb-4");

	}
	console.log("Host Info: " + window.location.host);

})();