$(function() {
	"use strict";
	new PerfectScrollbar(".header-notifications-list"), $(".mobile-search-icon").on("click", function() {
		$(".search-bar").addClass("full-search-bar")
	}), $(".search-close").on("click", function() {
		$(".search-bar").removeClass("full-search-bar")
	}), $(".mobile-toggle-menu").on("click", function() {
		$(".wrapper").addClass("toggled")
	}), $(".toggle-icon").click(function() {
		$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
			$(".wrapper").addClass("sidebar-hovered")
		}, function() {
			$(".wrapper").removeClass("sidebar-hovered")
		}))
	}), $(document).ready(function() {
		$(window).on("scroll", function() {
			$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
		}), $(".back-to-top").on("click", function() {
			return $("html, body").animate({
				scrollTop: 0
			}, 600), !1
		})
	}), $(function() {
		for (var e = window.location, o = $(".metismenu li a").filter(function() {
				return this.href == e
			}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
	}), $(function() {
		$("#menu").metisMenu()
	}), $(".chat-toggle-btn").on("click", function() {
		$(".chat-wrapper").toggleClass("chat-toggled")
	}), $(".chat-toggle-btn-mobile").on("click", function() {
		$(".chat-wrapper").removeClass("chat-toggled")
	}), $(".email-toggle-btn").on("click", function() {
		$(".email-wrapper").toggleClass("email-toggled")
	}), $(".email-toggle-btn-mobile").on("click", function() {
		$(".email-wrapper").removeClass("email-toggled")
	}), $(".compose-mail-btn").on("click", function() {
		$(".compose-mail-popup").show()
	}), $(".compose-mail-close").on("click", function() {
		$(".compose-mail-popup").hide()
	}), $(".switcher-btn").on("click", function() {
		$(".switcher-wrapper").toggleClass("switcher-toggled")
	}), $(".close-switcher").on("click", function() {
		$(".switcher-wrapper").removeClass("switcher-toggled")
	}), $("#lightmode").on("click", function() {
		$("html").attr("class", "light-theme"), localStorage.setItem('theme', 'light')
	}), $("#darkmode").on("click", function() {
		$("html").attr("class", "dark-theme"), localStorage.setItem('theme', 'dark')
	}), $("#semidark").on("click", function() {
		$("html").attr("class", "semi-dark")
	}), $("#minimaltheme").on("click", function() {
		$("html").attr("class", "minimal-theme")
	}), $("#headercolor1").on("click", function() {
		$("html").addClass("color-header headercolor1"), $("html").removeClass("headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor2").on("click", function() {
		$("html").addClass("color-header headercolor2"), $("html").removeClass("headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor3").on("click", function() {
		$("html").addClass("color-header headercolor3"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor4").on("click", function() {
		$("html").addClass("color-header headercolor4"), $("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor5").on("click", function() {
		$("html").addClass("color-header headercolor5"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor6").on("click", function() {
		$("html").addClass("color-header headercolor6"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8")
	}), $("#headercolor7").on("click", function() {
		$("html").addClass("color-header headercolor7"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8")
	}), $("#headercolor8").on("click", function() {
		$("html").addClass("color-header headercolor8"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3")
	})



	// sidebar colors 


	$('#sidebarcolor1').click(theme1);
	$('#sidebarcolor2').click(theme2);
	$('#sidebarcolor3').click(theme3);
	$('#sidebarcolor4').click(theme4);
	$('#sidebarcolor5').click(theme5);
	$('#sidebarcolor6').click(theme6);
	$('#sidebarcolor7').click(theme7);
	$('#sidebarcolor8').click(theme8);

	function theme1() {
		$('html').attr('class', 'color-sidebar sidebarcolor1');
	}

	function theme2() {
		$('html').attr('class', 'color-sidebar sidebarcolor2');
	}

	function theme3() {
		$('html').attr('class', 'color-sidebar sidebarcolor3');
	}

	function theme4() {
		$('html').attr('class', 'color-sidebar sidebarcolor4');
	}

	function theme5() {
		$('html').attr('class', 'color-sidebar sidebarcolor5');
	}

	function theme6() {
		$('html').attr('class', 'color-sidebar sidebarcolor6');
	}

	function theme7() {
		$('html').attr('class', 'color-sidebar sidebarcolor7');
	}

	function theme8() {
		$('html').attr('class', 'color-sidebar sidebarcolor8');
	}

});



$('[name="committed_amt"]').on('keyup', function() {
	checkDiscount();
});
$('[name="subcription_amt"').on('keyup', function() {
	checkDiscount();
});

function checkDiscount() {
	let discount = $('[name="committed_amt"]').val();
	let amount = $('[name="subcription_amt"]').val();
	if (amount != '' && discount != '') {
		discount = Number(discount);
		amount = Number(amount);
		if (discount >= amount) {
			$('[name="submit"]').prop('disabled', true);
			if ($('#discount-error').length > 0) {
				$('#discount-error').text('*Discount must be less than Subcription Amount')
			} else {
				let warning = $('<span id="discount-error" class="text-danger small"></span>');
				warning.text('*Discount must be less than Subcription Amount');
				$('[name="committed_amt"]').after(warning);
			}
		} else {
			$('[name="submit"]').prop('disabled', false);
			$('#discount-error').text('');
		}
	} else {
		$('[name="submit"]').prop('disabled', false);
		$('#discount-error').text('');
	}
}
function enableMultiCheckAll(parent_el='table') {
	// multicheck-container | table | any element
	$('.multi-check-all[type="checkbox"]').prop('indeterminate', false);
	$('.multi-check-all[type="checkbox"]').prop('checked', false);
	$('.multi-check-all[type="checkbox"]').on('change', function(e) {
		const checkItems = $(this).closest(parent_el).find('.multi-check-item[type="checkbox"]');
		if (this.checked === true) {
			checkItems.prop('checked', true);
		} else {
			checkItems.prop('checked', false);
		}
	});
	$('.multi-check-item[type="checkbox"]').on('change', function() {
		const allcheck = $(this).closest(parent_el).find('.multi-check-item[type="checkbox"]').length;
		const checked = $(this).closest(parent_el).find('.multi-check-item[type="checkbox"]:checked').length;
		const checkAllBtn = $(this).closest(parent_el).find('.multi-check-all[type="checkbox"]')
		if (checked == 0) {
			checkAllBtn.prop('indeterminate', false);
			checkAllBtn.prop('checked', false);
		} else if (allcheck == checked && checked != 0) {
			checkAllBtn.prop('indeterminate', false);
			checkAllBtn.prop('checked', true);
		} else if (checked < allcheck) {
			checkAllBtn.prop('checked', false);
			checkAllBtn.prop('indeterminate', true);
		} else {
			checkAllBtn.prop('indeterminate', false);
			checkAllBtn.prop('checked', false);
		}
	});
}
$('.multi-action-btn').on('click', function() {
	const multiCheckURL = $('.multi-check-item[type="checkbox"]:checked').serialize();
	const actionBtn = this;
	$(actionBtn).attr('href', `${$(actionBtn).attr('data-multi-action-page') ? $(actionBtn).attr('data-multi-action-page') : ''}${$(actionBtn).attr('data-multi-action') ? "?"+$(actionBtn).attr('data-multi-action')+"=true&" : '?'}${multiCheckURL}`)
});
$(document).ready(() => {
	enableMultiCheckAll('.multicheck-container');
});
/************************/
/****** Count words *****/
/************************/
function showCount(string, output_element) {
	$(output_element).text(string.length);
}
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
})