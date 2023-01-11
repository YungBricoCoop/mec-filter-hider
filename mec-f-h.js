jQuery(document).ready(function ($) {
	//TODO: Check if we are on the correct url to not influence other plugins
	let container = mec_f_h_vars?.container;
	let elements = mec_f_h_vars?.elements;
	
	if (!container || !elements)  return console.error('Missing container or elements');

	elements = elements.split(',').map((item) => item.trim());

	const buildSelector = (element) => {
		if (!element.startsWith('.') && !element.startsWith('#') && !element.includes('=')){
			console.error('Invalid selector : ' + element)
			return false
		}
		//TODO: Remove this and use basic custom attr syntax [attr=value]
		if(element.includes('=')){
			const [key, value] = element.split('=');
			return `*[${key}="${value}"]`;
		}
		return element;
	}

	container = buildSelector(container);
	if (!container) return

	elements.forEach((element) => {
		const elementSelector = buildSelector(element);
		if (!elementSelector) return 
		$(container).find(elementSelector).hide();
	});
});