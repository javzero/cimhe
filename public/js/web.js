/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
__webpack_require__(2);
__webpack_require__(3);
module.exports = __webpack_require__(4);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

var _ref;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//////////////////////////////
// 						    //
//        PLUGINS           //
//                          //
//////////////////////////////

new WOW().init();

//////////////////////////////
// 					        //
//        NAVIGATION        //
//                          //
//////////////////////////////

$(document).ready(function () {

	// var section       = $('#ActualSection').data('section');
	// var logo          = $('.navbar .navbar-brand');
	// var navbar        = $('.navbar-default');

	// function nav_logic() {

	// 	switch(section) {

	// 		//////// HOME /////////
	// 		case "home":
	// 			// $('body').css('padding-top','0');
	// 			logo.css('opacity','0');
	// 			// $('.navbar .navbar-right').css('border-bottom', '1px solid white');
	// 			navbar.addClass('home-nav');

	// 			$(window).scroll(function() {
	// 				var scrollPos = $(window).scrollTop();

	// 				if (scrollPos > 250) {
	// 					navbar.addClass('change-nav');
	// 					logo.css('opacity','100');
	// 				} else {
	// 					navbar.removeClass('change-nav');
	// 					logo.css('opacity','0');
	// 				}
	// 			});

	// 		break;

	// 		//////// PORTFOLIO /////////
	// 		case "portfolio":

	// 			navbar = $('.navbar-default');		
	// 			navbar.addClass('nav-portfolio');
	// 			$('body').css('background-color','#f9f9f9');
	// 			$(window).scroll(function() {
	// 				var scrollPos = $(window).scrollTop();

	// 				if (scrollPos > 250) {
	// 					navbar.addClass('change-nav');
	// 				} else {
	// 					navbar.removeClass('change-nav');
	// 				}
	// 			});

	// 		break;


	// 		//////// GENERIC /////////
	// 		default:
	// 			$(window).scroll(function() {

	// 				var scrollPos = $(window).scrollTop(),
	// 				navbar   = $('.navbar-default');

	// 				if (scrollPos > 250) {
	// 					navbar.addClass('change-nav');
	// 				} else {
	// 					navbar.removeClass('change-nav');
	// 				}
	// 			});
	//     }

	// }
	// // ----------- End Navigation Script ------------ //

	// //Activate nav effects in desktop
	// if (screen.width > 775) {
	//     nav_logic();
	// } else {

	// }


}); // Document Ready

// Home Parallax
var image = "{{ asset('webimages/gral/home/home-back.jpg') }}";
$('.main-home').parallax({ imageSrc: image });

var mySwiper = new Swiper('.swiper-container', (_ref = {
	pagination: true,
	spaceBetween: 20,
	autoHeight: true,
	slidesPerView: 4,
	autoplay: true
}, _defineProperty(_ref, 'autoplay', {
	delay: 2000
}), _defineProperty(_ref, 'delay', 0), _defineProperty(_ref, 'loop', true), _defineProperty(_ref, 'speed', 2500), _ref));

$(document).on('submit', '#MainContactForm', function (e) {
	e.preventDefault();
	var data = $(this).serialize();
	var route = "{{ url('mail_sender') }}";
	// var route  = "{{ url('test_sender') }}";
	var loader = '<img src="{{ asset("images/loaders/loader-sm.svg") }}"/>' + '<div style="color: #fff; margin-left: 15px">Enviando...</div>';

	$.ajax({
		type: "POST",
		url: route,
		dataType: 'json',
		data: data,
		beforeSend: function beforeSend() {
			var loader = "<img src='{{ asset('images/loaders/loader-sm.svg') }}'>";
			$('#ContactBtn').html('Enviando ' + loader);
		},
		success: function success(data) {
			$('#MainContactForm').hide();
			$('#FormSuccess').removeClass('Hidden');
			$('#FormResponse').hide();
			console.log(data);
		},
		error: function error(data) {
			$('#FormResponse').hide();
			$('#MainContactForm').hide();
			$('#ContactBtn').html('ENVIAR');
			$('#FormError').removeClass('Hidden');
			console.log(data);
		}
	});
});

console.log('ookok');

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 4 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);