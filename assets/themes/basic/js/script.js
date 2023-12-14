// add bg to nav
window.addEventListener("scroll", function () {
	let scrollpos = window.scrollY;
	const header = document.querySelector("nav");
	const headerHeight = header.offsetHeight;
	if (scrollpos >= headerHeight) {
		header.classList.add("active");
	} else {
		header.classList.remove("active");
	}
});

window.addEventListener("load", () => {
	setTimeout(() => {
		document.getElementById("preloader").style.cssText = `opacity: 0; visibility: hidden;`;
	}, 1000);
});

// active nav item
const navItem = document.getElementsByClassName("nav-link");
for (const element of navItem) {
	element.addEventListener("click", () => {
		for (const ele of navItem) {
			ele.classList.remove("active");
		}
		element.classList.add("active");
	});
}

var getTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
$(".timeZone").val(getTimeZone);

// tab
const tabs = document.getElementsByClassName("tab");
const contents = document.getElementsByClassName("content");
for (const element of tabs) {
	const tabId = element.getAttribute("tab-id");
	const content = document.getElementById(tabId);
	element.addEventListener("click", () => {
		for (const t of tabs) {
			t.classList.remove("active");
		}
		for (const c of contents) {
			c.classList.remove("active");
		}
		element.classList.add("active");
		content.classList.add("active");
	});
}

// copy text
const copyText = (id) => {
	const text = document.getElementById(id);
	text.select();
	navigator.clipboard.writeText(text.value);
	document.getElementById("copyBtn").innerText = "Link copied";
	setTimeout(() => {
		document.getElementById("copyBtn").innerText = "Copy Link";
	}, 1000);
};

// input file preview
const previewImage = (id) => {
	document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
};

const toggleSideMenu = () => {
	document.getElementById("sidebar").classList.toggle("active");
	document.getElementById("content").classList.toggle("active");
};

const toggleUserSideBar = (e) => {
	document.getElementById(e).classList.toggle("active");
};

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl);
});

$(document).ready(function () {
	$(".js-example-basic-single").select2();
	$(".js-example-basic-single-modal").select2({
		dropdownParent: $("#formModal"),
	});
	$(".js-example-basic-multiple-limit").select2({
		maximumSelectionLength: 5,
	});

	$(".testimonials").owlCarousel({
		loop: true,
		margin: 0,
		rtl: false,
		nav: true,
		dots: true,
		autoplay: true,
		autoplayTimeout: 3000,
		responsive: {
			0: {
				items: 1,
			},
			768: {
				items: 2,
			},
			992: {
				items: 2,
			},
		},
	});

	$("#shareBlock").socialSharingPlugin({
		urlShare: window.location.href,
		description: $("meta[name=description]").attr("content"),
		title: $("title").text(),
	});

	// RANGE SLIDER
	$(".js-range-slider").ionRangeSlider({
		type: "double",
		min: 0,
		max: 1000,
		from: 200,
		to: 500,
		grid: true,
	});
});

// Initialise Carousel
if (document.querySelector("#mainCarousel") != null) {

	const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
		Dots: false,
		Navigation: false,
	});

// Thumbnails
if (document.querySelector("#thumbCarousel") != null) {
	const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
		Sync: {
			target: mainCarousel,
			friction: 0,
		},
		Dots: false,
		Navigation: true,
		center: true,
		slidesPerPage: 1,
		infinite: false,
	});
}

	Fancybox.bind('[data-fancybox="gallery"]', {
		Carousel: {
			on: {
				change: (that) => {
					mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
						friction: 0,
					});
				},
			},
		},
	});


}


