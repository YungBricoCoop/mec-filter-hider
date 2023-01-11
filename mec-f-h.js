/**
 * Execute the code when the page is ready
 * @param {object} $ jquery
 */
const onPageReady = ($) => {
	const url = mec_f_h_vars?.url || '';
	let container = mec_f_h_vars?.container || '';
	let elements = mec_f_h_vars?.elements || '';

	// if not on the correct url, return 
	if (!checkCurrentUrl(url)) return;

	// if container or elements are not set, return
	if (!container || !elements) return console.error('Missing container or elements');

	// split the elements by comma and trim the spaces
	elements = elements.split(',').map((item) => item.trim());

	// check if the container is valid
	container = checkSelector(container);
	if (!container) return

	// hide the elements in the container
	elements.forEach((element) => {
		const elementSelector = checkSelector(element);
		if (!elementSelector) return
		$(container).find(elementSelector).hide();
	});
}

/**
 * Check if the selector is valid
 * @param {string} element 
 * @returns true if valid selector, false if not
 */
const checkSelector = (element = '') => {
	if (!element.startsWith('.') && !element.startsWith('#') && !element.includes('[')) {
		console.error('Invalid selector : ' + element)
		return false
	}
	return element;
}

/**
 * Check if the current url includes the url/text passed
 * @param {string} url 
 * @returns true if it includes, false if not
 */
const checkCurrentUrl = (url = '') => {
	return window.location.href.includes(url);
}

jQuery(document).ready(onPageReady);