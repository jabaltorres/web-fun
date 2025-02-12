const bigFlipper = {
	wrapper: document.getElementById('big-flipper-wrapper'),
	images: Array.from(document.querySelectorAll('#big-flipper-wrapper img')),
	originalOrder: [],  // Array to hold clones of the original images

	// Set the height of the wrapper to the height of the first image
	setWrapperHeight: function() {
		let imageHeight = this.images[0].offsetHeight;
		this.wrapper.style.height = imageHeight + "px";
	},

	// Add 'active' class to the first image and remove from others
	makeFirstImageActive: function() {
		Array.from(this.images).forEach(img => img.classList.remove("active"));
		this.images[0].classList.add("active");
	},

	// Captures the original order of images on page load
	captureOriginalOrder: function() {
		this.originalOrder = this.images.map(img => img.cloneNode());
	},

	// Restores the images to their original order
	restoreOriginalOrder: function() {
		let parent = this.wrapper;
		parent.innerHTML = ''; // Clear the current images
		this.originalOrder.forEach(img => parent.appendChild(img));
		this.images = Array.from(document.querySelectorAll('#big-flipper-wrapper img')); // Reassign the images collection
		this.makeFirstImageActive();
	},

	// Moves the first image to the end of the list
	moveImageForward: function() {
		let firstImage = this.images[0];
		firstImage.parentNode.appendChild(firstImage);
		this.makeFirstImageActive();
		this.incrementProgress();
	},

	// Moves the last image to the beginning of the list
	moveImageBack: function() {
		let lastImage = this.images[this.images.length - 1];
		let firstImage = this.images[0];
		firstImage.parentNode.insertBefore(lastImage, firstImage);
		this.makeFirstImageActive();
		this.decrementProgress();
	},

	// Retrieves the progress element
	getProgressElement: function() {
		return document.getElementById('big-flipper-progress');
	},

	// Retrieves the element that displays the progress text
	getProgressTextElement: function() {
		return document.getElementById('big-flipper-progress-value');
	},

	// Initializes the progress to the first step
	setProgress: function() {
		let progress = this.getProgressElement();
		let progressMaxValue = progress.getAttribute('max');
		let progressSteps = progressMaxValue / this.images.length;
		progress.setAttribute('value', progressSteps);
		let progressTextValue = this.getProgressTextElement();
		progressTextValue.innerText = `${progressSteps}%`;
	},

	// Increments the progress based on the total number of images
	incrementProgress: function() {
		let progress = this.getProgressElement();
		let progressValue = Number(progress.getAttribute('value'));
		let progressMaxValue = Number(progress.getAttribute('max'));
		let progressSteps = progressMaxValue / this.images.length;

		// Ensure we loop back to the start if we exceed the max
		if (progressValue + progressSteps > progressMaxValue) {
			progressValue = progressSteps; // Reset to the first step, if looping is desired
		} else {
			progressValue += progressSteps;
		}
		progress.setAttribute('value', progressValue);
		let progressTextValue = this.getProgressTextElement();
		progressTextValue.innerText = `${Math.min(progressValue, progressMaxValue).toFixed(1)}%`; // Ensure it does not display over 100%
	},

	// Decrements the progress based on the total number of images
	decrementProgress: function() {
		let progress = this.getProgressElement();
		let progressValue = Number(progress.getAttribute('value'));
		let progressMaxValue = Number(progress.getAttribute('max'));
		let progressSteps = progressMaxValue / this.images.length;

		// When decrementing, if progressValue is at the first step, wrap around to 100%
		if (progressValue - progressSteps <= 0) {
			progressValue = progressMaxValue; // Wrap around to 100%
		} else {
			progressValue -= progressSteps;
		}

		progress.setAttribute('value', progressValue);
		let progressTextValue = this.getProgressTextElement();
		progressTextValue.innerText = `${progressValue.toFixed(1)}%`;
	},

	// Resets the progress to the initial state and restores the original image order
	resetProgressToOne: function() {
		this.setProgress();
		this.restoreOriginalOrder();
	},

	// Initializes all functionalities
	init: function() {
		this.captureOriginalOrder();
		this.setWrapperHeight();
		this.makeFirstImageActive();
		this.setProgress();

		document.getElementById('action-button').addEventListener("click", () => this.moveImageForward());
		document.getElementById('reset-button').addEventListener("click", () => this.resetProgressToOne());

		document.addEventListener('keydown', event => {
			if(event.key === "ArrowRight") {
				this.moveImageForward();
			} else if(event.key === "ArrowLeft") {
				this.moveImageBack();
			}
		});
	}
};

// Load bigFlipper when the page loads if the big-flipper class exists
window.onload = function() {
	if (document.getElementsByClassName('big-flipper').length > 0) {
		bigFlipper.init();
	}
};
