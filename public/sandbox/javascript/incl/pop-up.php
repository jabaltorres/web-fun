<?php
// Define a base directory relative to the current script location or document root
$baseDir = $_SERVER['DOCUMENT_ROOT'];

// Assuming this script resides in a directory accessible at the web root
$assetsPath = '/assets/images/Facebox/Images-Circle-640px/';

// Construct the filesystem path where images are stored
$filesystemPath = $baseDir . $assetsPath;

// Dynamically generate the URL path based on the server name and the assets path
$urlPath = '//' . $_SERVER['HTTP_HOST'] . $assetsPath;

// Function to retrieve images from a directory
function getImagesFromDir($path)
{
    $images = [];
    if ($img_dir = opendir($path)) {
        while (false !== ($img_file = readdir($img_dir))) {
            if (preg_match("/\.(gif|jpg|png)$/", $img_file)) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    } else {
        error_log("Failed to open directory at path: $path");
        return [];
    }
    return $images;
}

// Function to get a random image from an array
function getRandomFromArray($ar)
{
    return !empty($ar) ? $ar[array_rand($ar)] : null;
}

$imgList = getImagesFromDir($filesystemPath);
$img = getRandomFromArray($imgList);
?>

<?php if ($img): ?>
    <div id="pop-up">
    <span id="img-container">
        <span id="close-btn">X</span>
        <a href="//web-fun.fivetwofive.com" target="_blank">
            <img src="<?php echo htmlspecialchars($urlPath . $img); ?>" alt="Image"/>
        </a>
    </span>
    </div>
<?php endif; ?>

<script>
	const fiveTwoFivePopUp = {
		popUpContainer: null,
		closeBtn: null,
		kookieName: "returnvisitor",

		init: function () {
			this.popUpContainer = document.getElementById('pop-up');
			this.closeBtn = document.getElementById("close-btn");

			this.addEventListeners();
			this.checkCookie();
		},

		addEventListeners: function () {
			this.closeBtn.addEventListener("click", () => this.hidePopUp());
			this.popUpContainer.addEventListener("click", () => this.hidePopUp());
		},

		hidePopUp: function () {
			this.popUpContainer.style.display = "none";
		},

		showPopUp: function () {
			this.popUpContainer.style.display = "initial";
		},

		setCookie: function (cname, cvalue, exdays) {
			const d = new Date();
			// d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000)); // cookie expires in 24 hours
			d.setTime(d.getTime() + (exdays * 60 * 1000)); // cookie expires in 10 seconds
			const expires = "expires=" + d.toUTCString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		},

		getCookie: function (cname) {
			const name = cname + "=";
			const ca = document.cookie.split(';');
			for (let i = 0; i < ca.length; i++) {
				let c = ca[i].trim();
				if (c.indexOf(name) === 0) {
					return c.substring(name.length);
				}
			}
			return "";
		},

		checkCookie: function () {
			const key = this.getCookie(this.kookieName);
			if (key !== "") {
				this.hidePopUp();
				console.log("Welcome back user");
			} else {
				this.setCookie(this.kookieName, "yes", 1);
				this.showPopUp();
				console.log("This is your first time here");
			}
		}
	};

	document.addEventListener("DOMContentLoaded", function () {
		fiveTwoFivePopUp.init();
	});
</script>