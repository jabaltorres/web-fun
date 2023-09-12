const bigFlipper = {
	// properties
	wrapper: document.getElementById('big-flipper-wrapper'),
	flipperValue: document.getElementById('big-flipper-wrapper-value'),
	images: document.getElementsByTagName('img'),

	// methods
	setWrapperHeight: function(){
		let imageHeight = this.images[0].offsetHeight;
		this.wrapper.style.height = "" + imageHeight + "px";
		// console.log('setting wrapper height');
	},
	makeFirstImageActive: function(){
		this.images[0].classList.add("active");
		// console.log('making first image active');
	},
	makeActive: function(){

		// remove active class from all images
		for (var i = 0; i < this.images.length; i++){
			this.images[i].classList.remove("active");
		}

		//add active class to first image
		this.images[0].classList.add("active");

		// console.log('making image active');
	},
	moveImageForward: function(){

		let firstImage = this.images[0];

		firstImage.parentNode.appendChild(firstImage);

		// make first image active
		bigFlipper.makeActive();

		// increment progress
		bigFlipper.incrementProgress();

		console.log('moving image forward');
	},
	moveImageBack: function(){
		let lastImage = this.images[this.images.length - 1];
		let firstImage = this.images[0];

		firstImage.parentNode.insertBefore(lastImage, firstImage);

		bigFlipper.makeActive();

		bigFlipper.decrementProgress();

		console.log('moving image back');
	},
	autom8: function(){
		let images = this.images;
		let i = 1;
		let loopThroughImages = function () {
			if (i < images.length) {
				bigFlipper.moveImageForward();
				++i;
				setTimeout(loopThroughImages, 1000);
			}
		};

		setTimeout(loopThroughImages, 1000);

	},
	getProgressElement: function(){
		return document.getElementById('big-flipper-progress');
	},
	getProgressTextElement: function(){
		return document.getElementById('big-flipper-progress-value');
	},
	setProgress: function(){
		// get progress element
		let progress = bigFlipper.getProgressElement();
		let progressTextValue = bigFlipper.getProgressTextElement();

		// get progress value
		let progressValue = progress.getAttribute('value');

		// get progress max
		let progressMaxValue = progress.getAttribute('max');

		// divide progress max by length of images
		let progressSteps = progressMaxValue / this.images.length;

		// convert progress value to number
		progressValue = Number(progressValue);

		console.log(`progress: ${progressValue}, and max: ${progressMaxValue}`);
		console.log(`progress steps: ${progressSteps}`);

		progress.setAttribute('value', progressValue + progressSteps);

		// set progress inner text to progress value
		progress.innerText = progressValue + progressSteps;
		let progressTextValueString = progressValue + progressSteps;
		progressTextValue.innerText = `${progressTextValueString}%`;
		console.log('setting initial progress value:' + progress.getAttribute('value'));
	},
	addNums: function($num1, $num2){
		// make sure they are numbers
		$num1 = Number($num1);
		$num2 = Number($num2);
		return $num1 + $num2;
	},
	subtractNum: function($num1, $num2){
		$num1 = Number($num1);
		$num2 = Number($num2);
		return $num1 - $num2;
	},
	incrementProgress: function(){
		// get progress element
		let progress = bigFlipper.getProgressElement();
		let progressTextValue = bigFlipper.getProgressTextElement();

		// get progress value
		let progressValue = progress.getAttribute('value');
		progressValue = Number(progressValue);

		// get progress max
		let progressMaxValue = progress.getAttribute('max');
		progressMaxValue = Number(progressMaxValue);

		// divide progress max by length of images
		let progressSteps = progressMaxValue / this.images.length;

		if (progressValue === progressMaxValue) {
			progressValue = progressSteps;
			progress.setAttribute('value', progressValue);
			progressTextValue.innerText = `${progressSteps}%`;
		} else {
			let progressNumberValue = bigFlipper.addNums(progressValue, progressSteps)
			progress.setAttribute('value', progressNumberValue);
			progressTextValue.innerText = `${progressNumberValue}%`;
		}
	},
	decrementProgress: function(){
		// get progress element
		let progress = bigFlipper.getProgressElement();
		let progressTextValue = bigFlipper.getProgressTextElement();

		// get progress value
		let progressValue = progress.getAttribute('value');
		progressValue = Number(progressValue);

		// get progress max
		let progressMaxValue = progress.getAttribute('max');
		progressMaxValue = Number(progressMaxValue);

		// divide progress max by length of images
		let progressSteps = progressMaxValue / this.images.length;

		// if progress value is 0, set it to max value
		if (progressValue === progressSteps) {
			progress.setAttribute('value', progressMaxValue);
			progressTextValue.innerText = `${progressMaxValue}%`;

		} else {
			progress.setAttribute('value', progressValue - progressSteps);
			let progressTextValueString = bigFlipper.subtractNum(progressValue, progressSteps);
			progressTextValue.innerText = `${progressTextValueString}%`;
		}
	},
	resetProgressToOne: function(){
		// get progress element
		let progress = bigFlipper.getProgressElement();

		// get progress max
		let progressMaxValue = progress.getAttribute('max');

		// divide progress max by length of images
		let progressSteps = progressMaxValue / this.images.length;

		// convert progress value to number
		progressSteps = Number(progressSteps);

		progress.setAttribute('value', progressSteps);
	},

	// init
	init: function(){
		// console.log('init');
		let actionBtn = document.getElementById('action-button');
		actionBtn.addEventListener("click", function () {
			// console.log('button clicked');
			bigFlipper.moveImageForward();
		});

		let resetBtn = document.getElementById('reset-button');
		resetBtn.addEventListener("click", function () {
			console.log('reset button clicked');
			bigFlipper.resetProgressToOne();
		});

		bigFlipper.setWrapperHeight();
		bigFlipper.makeFirstImageActive();
		// bigFlipper.autom8();
		bigFlipper.setProgress();

		// if right arrow key is press move image
		document.addEventListener('keydown', function(event) {
			if(event.key === "ArrowRight") {
				bigFlipper.moveImageForward();
			}
		});

		// if left arrow key is press move image back
		document.addEventListener('keydown', function(event) {
			if(event.key === "ArrowLeft") {
				bigFlipper.moveImageBack();
			}
		});
	},

};

// window.onload = bigFlipper.init();

// onpageload and if element with class of big-flipper exists load bigFlipper
window.onload = function () {
	if (document.getElementsByClassName('big-flipper').length > 0) {
		bigFlipper.init();
	}
};