/**
 * Storeberry AI Feature Tabs – vanilla JS tab controller.
 */
(function () {
	'use strict';

	var FADE_MS = 350;

	function getTabs(section) {
		return Array.prototype.slice.call(section.querySelectorAll('[role="tab"]'));
	}

	function getPanels(section) {
		return Array.prototype.slice.call(section.querySelectorAll('[role="tabpanel"]'));
	}

	function setActiveTab(section, index) {
		var tabs = getTabs(section);
		var panels = getPanels(section);

		if (!tabs.length || index < 0 || index >= tabs.length) {
			return;
		}

		var currentPanel = panels.find(function (panel) {
			return panel.classList.contains('is-active');
		});
		var nextPanel = panels[index];

		if (currentPanel === nextPanel) {
			return;
		}

		tabs.forEach(function (tab, i) {
			var isActive = i === index;
			tab.classList.toggle('is-active', isActive);
			tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
			tab.setAttribute('tabindex', isActive ? '0' : '-1');
		});

		if (!nextPanel) {
			return;
		}

		if (!currentPanel) {
			nextPanel.classList.add('is-active');
			nextPanel.removeAttribute('hidden');
			return;
		}

		currentPanel.classList.add('is-fading-out');
		currentPanel.classList.remove('is-active');

		window.setTimeout(function () {
			currentPanel.classList.remove('is-fading-out');
			currentPanel.setAttribute('hidden', 'hidden');

			nextPanel.removeAttribute('hidden');
			nextPanel.classList.add('is-fading-in');

			window.requestAnimationFrame(function () {
				nextPanel.classList.add('is-active');
				nextPanel.classList.remove('is-fading-in');
			});
		}, FADE_MS);
	}

	function getTabIndex(tab) {
		var value = parseInt(tab.getAttribute('data-tab-index'), 10);
		return isNaN(value) ? 0 : value;
	}

	function onTabClick(event) {
		var tab = event.currentTarget;
		var section = tab.closest('.saft-section');

		if (!section) {
			return;
		}

		setActiveTab(section, getTabIndex(tab));
	}

	function onTabKeydown(event) {
		var tab = event.currentTarget;
		var section = tab.closest('.saft-section');

		if (!section) {
			return;
		}

		var tabs = getTabs(section);
		var currentIndex = tabs.indexOf(tab);
		var nextIndex = currentIndex;

		if (event.key === 'Enter' || event.key === ' ') {
			event.preventDefault();
			setActiveTab(section, currentIndex);
			return;
		}

		if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
			nextIndex = (currentIndex + 1) % tabs.length;
		} else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
			nextIndex = (currentIndex - 1 + tabs.length) % tabs.length;
		} else if (event.key === 'Home') {
			nextIndex = 0;
		} else if (event.key === 'End') {
			nextIndex = tabs.length - 1;
		} else {
			return;
		}

		event.preventDefault();
		tabs[nextIndex].focus();
		setActiveTab(section, nextIndex);
	}

	function initSection(section) {
		if (section.getAttribute('data-saft-init') === '1') {
			return;
		}

		section.setAttribute('data-saft-init', '1');

		var tabs = getTabs(section);
		var panels = getPanels(section);
		var defaultIndex = parseInt(section.getAttribute('data-default-tab'), 10);

		if (isNaN(defaultIndex) || defaultIndex < 0) {
			defaultIndex = 0;
		}

		if (defaultIndex >= tabs.length) {
			defaultIndex = 0;
		}

		panels.forEach(function (panel, i) {
			if (i === defaultIndex) {
				panel.classList.add('is-active');
				panel.removeAttribute('hidden');
			} else {
				panel.classList.remove('is-active');
				panel.setAttribute('hidden', 'hidden');
			}
		});

		tabs.forEach(function (tab, i) {
			var isActive = i === defaultIndex;
			tab.classList.toggle('is-active', isActive);
			tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
			tab.setAttribute('tabindex', isActive ? '0' : '-1');
			tab.addEventListener('click', onTabClick);
			tab.addEventListener('keydown', onTabKeydown);
		});
	}

	function initAll(root) {
		var scope = root || document;
		var sections = scope.querySelectorAll('.saft-section');

		Array.prototype.forEach.call(sections, initSection);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initAll(document);
		});
	} else {
		initAll(document);
	}

	/* Elementor frontend hook */
	window.addEventListener('elementor/frontend/init', function () {
		if (
			typeof elementorFrontend === 'undefined' ||
			!elementorFrontend.hooks
		) {
			return;
		}

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/storeberry_ai_feature_tabs.default',
			function ($scope) {
				var element = $scope[0] || $scope;

				if (element) {
					initAll(element);
				}
			}
		);
	});
})();
