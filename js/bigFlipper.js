const AddBorder = {

	init: function(){
		let links = document.getElementsByTagName('img');
		let wrapper = document.getElementById('wrapper');
		let wrapperHeight = wrapper.offsetHeight;
		let imageHeight = links[0].offsetHeight;

		wrapper.style.height = "" + imageHeight + "px";

		AddBorder.makeActive();

		var actionBtn = document.getElementById('action-button');
		actionBtn.addEventListener("click", AddBorder.moveImage);

		AddBorder.autom8();
	},
	makeActive: function(){
		var firstImage = wrapper.firstElementChild;
		firstImage.classList.add("active");
	},
	moveImage: function(){

		var firstImage = wrapper.firstElementChild;
		var nextImage = firstImage.nextElementSibling.classList.add("active");

		firstImage.parentNode.appendChild(firstImage);
		setTimeout(firstImage.classList.remove("active"),1000);
	},
	autom8: function(){
		var links = document.getElementsByTagName('img');
		var i = 0;
		var callback = function () {
			if (i < links.length) {
				AddBorder.moveImage();
				++i;
				setTimeout(callback, 1000);
			}
		};
		setTimeout(callback, 1000);

		// var callback = function () {
		//   var links = document.getElementsByTagName('img');
		//   for (var i = 0; i < links.length; i++){
		//     console.log([i])
		//     setTimeout(AddBorder.moveImage, 1000);
		//   }
		// };
		// setTimeout(callback, 1000);
	}
};

document.addEventListener("DOMContentLoaded", function() {
	//do work
	AddBorder.init();
});

