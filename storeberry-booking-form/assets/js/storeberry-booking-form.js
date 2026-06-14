/**
 * Storeberry Booking Form – vanilla JS AJAX submit.
 */
(function () {
	'use strict';

	function getConfig() {
		return window.storeberryBookingForm || {};
	}

	function setMessage(messageEl, text, type) {
		if (!messageEl) {
			return;
		}

		messageEl.textContent = text;
		messageEl.classList.add('is-visible');
		messageEl.classList.remove('is-success', 'is-error');
		messageEl.classList.add(type === 'success' ? 'is-success' : 'is-error');
		messageEl.setAttribute('role', 'alert');
	}

	function clearMessage(messageEl) {
		if (!messageEl) {
			return;
		}

		messageEl.textContent = '';
		messageEl.classList.remove('is-visible', 'is-success', 'is-error');
		messageEl.removeAttribute('role');
	}

	function getFormData(form) {
		var wrap = form.closest('.sb-booking-form-wrap');
		var config = getConfig();

		return {
			action: config.action || 'storeberry_booking_form_submit',
			nonce: config.nonce || '',
			name: form.querySelector('[name="name"]') ? form.querySelector('[name="name"]').value.trim() : '',
			email: form.querySelector('[name="email"]') ? form.querySelector('[name="email"]').value.trim() : '',
			country_code: form.querySelector('[name="country_code"]') ? form.querySelector('[name="country_code"]').value : '',
			phone: form.querySelector('[name="phone"]') ? form.querySelector('[name="phone"]').value.trim() : '',
			page_url: window.location.href,
			recipient: wrap ? wrap.getAttribute('data-recipient') || '' : '',
			subject: wrap ? wrap.getAttribute('data-subject') || '' : '',
			success_message: wrap ? wrap.getAttribute('data-success-message') || '' : '',
			error_message: wrap ? wrap.getAttribute('data-error-message') || '' : '',
			required_message: wrap ? wrap.getAttribute('data-required-message') || '' : '',
			name_required: wrap ? wrap.getAttribute('data-name-required') || '0' : '0',
			email_required: wrap ? wrap.getAttribute('data-email-required') || '0' : '0',
			phone_required: wrap ? wrap.getAttribute('data-phone-required') || '0' : '0'
		};
	}

	function handleSubmit(event) {
		event.preventDefault();

		var form = event.currentTarget;
		var config = getConfig();
		var submitBtn = form.querySelector('.sb-booking-form__submit');
		var messageEl = form.querySelector('.sb-booking-form__message');
		var originalText = submitBtn ? submitBtn.textContent : '';

		if (!config.ajaxUrl) {
			setMessage(messageEl, 'AJAX is not configured.', 'error');
			return;
		}

		clearMessage(messageEl);

		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.setAttribute('aria-busy', 'true');
			if (submitBtn.getAttribute('data-loading-text')) {
				submitBtn.textContent = submitBtn.getAttribute('data-loading-text');
			}
		}

		var body = new URLSearchParams(getFormData(form));

		fetch(config.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: body.toString()
		})
			.then(function (response) {
				return response.json().then(function (json) {
					return { ok: response.ok, json: json };
				});
			})
			.then(function (result) {
				var payload = result.json || {};
				var data = payload.data || {};
				var message = data.message || '';

				if (payload.success) {
					setMessage(messageEl, message, 'success');
					form.reset();
					return;
				}

				setMessage(messageEl, message || 'Something went wrong. Please try again.', 'error');
			})
			.catch(function () {
				var wrap = form.closest('.sb-booking-form-wrap');
				var fallback = wrap ? wrap.getAttribute('data-error-message') : '';
				setMessage(messageEl, fallback || 'Something went wrong. Please try again.', 'error');
			})
			.finally(function () {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.removeAttribute('aria-busy');
					submitBtn.textContent = originalText;
				}
			});
	}

	function initForm(form) {
		if (form.getAttribute('data-sb-booking-init') === '1') {
			return;
		}

		form.setAttribute('data-sb-booking-init', '1');
		form.addEventListener('submit', handleSubmit);
	}

	function initAll(root) {
		var scope = root || document;
		var forms = scope.querySelectorAll('.sb-booking-form');

		Array.prototype.forEach.call(forms, initForm);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll(document);
		});
	} else {
		initAll(document);
	}

	window.addEventListener('elementor/frontend/init', function () {
		if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) {
			return;
		}

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/storeberry_booking_form.default',
			function ($scope) {
				var element = $scope[0] || $scope;
				if (element) {
					initAll(element);
				}
			}
		);
	});
})();
