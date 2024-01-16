/**
 * File navigation.js.
 *
 * navigation support for dropdown menus.
 */
( function($) {
	let navMob = document.getElementById('menu-mob');
	let navMenu = document.getElementById('primary');
	
	let liElementsMob = navMob ? navMob.querySelectorAll('li') : null;
	let liElementsMenu = navMenu ? navMenu.querySelectorAll('li') : null;
	
	// Loop through each <li> element in navMob
	if (liElementsMob) {
			liElementsMob.forEach(function (li) {
					handleMenuItem(li);
			});
	}
	
	// Loop through each <li> element in navMenu
	if (liElementsMenu) {
			liElementsMenu.forEach(function (li) {
					handleMenuItem(li);
			});
	}
	
	function handleMenuItem(li) {
			// Find the <a> element inside the <li>
			let aElement = li.querySelector('a');
	
			// Check if the <a> element exists and its text content is "Pages"
			if (aElement && aElement.textContent.trim() === 'Pages') {
					let subMenu = aElement.parentNode.querySelector('ul.sub-menu');
					aElement.addEventListener('click', function (e) {
							e.preventDefault();
							subMenu.classList.toggle('sub-menu--flex');
							aElement.classList.toggle('nav-active');
							if (window.getComputedStyle(subMenu).display === 'flex') {
									// Toggle the display property after a delay
									const startTime = performance.now();
	
									function toggleSubMenu(timestamp) {
											if (timestamp - startTime < 800) {
													// Continue requesting animation frames until the delay is reached
													requestAnimationFrame(toggleSubMenu);
											} else {
													// Toggle the display property after the delay
													subMenu.style.display = (subMenu.style.display === 'flex') ? 'none' : 'flex';
											}
									}
									// Start the animation
									requestAnimationFrame(toggleSubMenu);
							} else {
									subMenu.style.display = (subMenu.style.display === 'flex') ? 'none' : 'flex';
							}
					});
			}
	}

	// Search logic
	let navMobile = document.querySelector('.navbar');
	let searchBtn = document.querySelector('.search-btn');
	let loginRegister = document.querySelector('.login-registration');
	let cartBlock = document.querySelector('.cart-block');
	let searchForm = document.querySelector('#search-form');
	let searchClose = document.querySelector('.search-close');
	searchBtn.addEventListener('click', function(e) {
		e.preventDefault();
		if (window.getComputedStyle(loginRegister).display === 'flex') {
			searchBtn.style.display = 'none';
			navMenu.style.display = 'none';
			loginRegister.style.display = 'none';
			cartBlock.style.display = 'none';
			navMobile.style.display = 'none';
			searchForm.style.display = 'flex';
		} 
	})
	searchClose.addEventListener('click', function(e) {
		e.preventDefault();
		if (window.getComputedStyle(loginRegister).display === 'none' && window.innerWidth > 992) {
			searchBtn.style.display = 'flex';
			navMenu.style.display = 'flex';
			loginRegister.style.display = 'flex';
			cartBlock.style.display = 'flex';
			searchForm.style.display = 'none';
		} else {
			searchBtn.style.display = 'flex';
			loginRegister.style.display = 'flex';
			cartBlock.style.display = 'flex';
			navMobile.style.display = 'flex';
			searchForm.style.display = 'none';
		}
	})
	// Function to handle the changes based on window width
	function handleWindowResize() {
		if (window.innerWidth > 992) {
				navMenu.style.display = 'flex';
				navMobile.style.display = 'none';
		} else {
				navMenu.style.display = 'none';
				navMobile.style.display = 'flex';
		}
	}

	// Initial setup
	handleWindowResize();

	// Create a ResizeObserver
	let resizeObserver = new ResizeObserver(handleWindowResize);

	// Observe changes in the window size
	resizeObserver.observe(document.body);


	document.addEventListener('DOMContentLoaded', function() {
    let burgerIcon = document.getElementById('burger-icon');
    let menu = document.getElementById('menu-mob');
		let exitBtn = document.querySelector('.exit-btn');

    burgerIcon.addEventListener('click', function() {
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });

		exitBtn.addEventListener('click', function() {
			menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
	});

    // Close the menu when clicking outside
    document.addEventListener('click', function(event) {
			if (!menu.contains(event.target) && event.target !== burgerIcon) {
					menu.style.display = 'none';
			}
		});
	});

	jQuery(document).ready(function($) {
			// Disable click on the specified anchor elements
			$('.header .container .main-navigation #primary > li > .sub-menu > li > a').on('click', function(e) {
					e.preventDefault(); // Prevent the default click behavior
			});
	});

	// SIDE MENU

	document.addEventListener('DOMContentLoaded', function() {
    var targetElementBtnSelector = '.wc-block-mini-cart__shopping-button';
    var processedElements = new Set();

    var updateElement = function(btnSelector) {
        // Remove the href attribute from the button
        var targetElementBtn = document.querySelector(btnSelector);
        if (targetElementBtn && !processedElements.has(targetElementBtn)) {
            processedElements.add(targetElementBtn);

            targetElementBtn.removeAttribute('href');
            targetElementBtn.textContent = 'Return to shop';

            targetElementBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.wc-block-components-drawer__close').click();
            });
        }
    };

    // Function to check if the target element already exists and update it
    var checkAndUpdate = function() {
        updateElement(targetElementBtnSelector);
    };

    // Check if the target element already exists on page load
    checkAndUpdate();

    // Create a MutationObserver to watch for changes in the DOM
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            // Check if the target element or a descendant is added or modified
            if (
                mutation.type === 'childList' &&
                (mutation.target.matches(targetElementBtnSelector) ||
                 mutation.target.querySelector(targetElementBtnSelector))
            ) {
                // If the target element exists or is added, update it
                checkAndUpdate();
            }
        });
    });

    // Configure and start the observer
    var observerConfig = { childList: true, subtree: true };
    observer.observe(document.body, observerConfig);
});



document.addEventListener('DOMContentLoaded', function () {
	var parentElementSelector = '.wc-block-cart-items__row';
	var quantityBlock = '.wc-block-cart-item__quantity';
	var countBlockSelector = '.wc-block-components-quantity-selector__input';
	var minusBlockSelector = '.wc-block-components-quantity-selector__button--minus';
	var plusBlockSelector = '.wc-block-components-quantity-selector__button--plus';
	var priceValueSelector = '.wc-block-components-product-price__value';
	var processedElements = new Set();

	var initializeElements = function (quantityBlock, countBlockSelector, minusBlockSelector, plusBlockSelector, priceValueSelector) {
			var parentElements = document.querySelectorAll(parentElementSelector);
			parentElements.forEach(function (parentElement) {
					var quantity = parentElement.querySelector(quantityBlock);
					var countBlock = parentElement.querySelector(countBlockSelector);
					var minus = parentElement.querySelector(minusBlockSelector);
					var plus = parentElement.querySelector(plusBlockSelector);
					var priceValueElement = parentElement.querySelector(priceValueSelector);

					if (countBlock && quantity && minus && plus && priceValueElement && !processedElements.has(quantity)) {
							processedElements.add(quantity);

							quantity.removeAttribute('href');

							var newDiv = document.createElement('div');
							newDiv.classList.add('count-x-price');
							quantity.appendChild(newDiv);

							var newCount = document.createElement('p');
							newCount.classList.add('count');
							newDiv.appendChild(newCount);

							var newX = document.createElement('span');
							newX.classList.add('x-item');
							newX.innerHTML = 'x';
							newDiv.appendChild(newX);

							var newPrice = document.createElement('p');
							newPrice.classList.add('price');
							newDiv.appendChild(newPrice);

							// Initialize with default values
							var defaultCount = parseInt(countBlock.value);
							var defaultPriceComponents = getPriceComponents(priceValueElement.textContent);
							newCount.innerHTML = defaultCount;
							newPrice.innerHTML = formatPrice(defaultCount * defaultPriceComponents.value, defaultPriceComponents.currency);

							// Add readonly attribute to the countBlock
							countBlock.setAttribute('readonly', 'readonly');

							minus.addEventListener('click', function () {
									updateCountAndPrice(countBlock, newCount, priceValueElement, newPrice);
							});

							plus.addEventListener('click', function () {
									updateCountAndPrice(countBlock, newCount, priceValueElement, newPrice);
							});
					}
			});
	};

	var updateCountAndPrice = function (countBlock, newCount, priceValueElement, newPrice) {
			var startTime = performance.now();
			var currentTime = performance.now();

			var updateValues = function () {
					var countVal = parseInt(countBlock.value);
					newCount.innerHTML = countVal;

					var priceComponents = getPriceComponents(priceValueElement.textContent);
					newPrice.innerHTML = formatPrice(countVal * priceComponents.value, priceComponents.currency);
			};

			var checkAndRequestAnimationFrame = function () {
					currentTime = performance.now();

					if (currentTime - startTime < 500) {
							updateValues();
							requestAnimationFrame(checkAndRequestAnimationFrame);
					}
			};

			checkAndRequestAnimationFrame();
	};

	var getPriceComponents = function (priceString) {
			var matches = priceString.match(/([^\d]*)([\d,.]+)/);
			return {
					currency: matches[1].trim(),
					value: parseFloat(matches[2].replace(',', ''))
			};
	};

	var formatPrice = function (value, currency) {
			return currency + value.toFixed(2);
	};

	var checkAndUpdate = function () {
			initializeElements(quantityBlock, countBlockSelector, minusBlockSelector, plusBlockSelector, priceValueSelector);
	};

	checkAndUpdate();

	var observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (mutation) {
					if (
							mutation.type === 'childList' &&
							(mutation.target.matches(countBlockSelector) ||
									mutation.target.querySelector(countBlockSelector))
					) {
							checkAndUpdate();
					}
			});
	});

	var observerConfig = { childList: true, subtree: true };
	observer.observe(document.body, observerConfig);
});

document.addEventListener('DOMContentLoaded', function () {
	var parentElementSelector = '.wc-block-cart-items__row';
	var targetSelector = '.wc-block-mini-cart__footer';
	var buttonsDiv = '.wc-block-mini-cart__footer-actions';
	var moneyAmount = '.wc-block-components-totals-item__value';
	var minusBlockSelector = '.wc-block-components-quantity-selector__button--minus';
	var plusBlockSelector = '.wc-block-components-quantity-selector__button--plus';
	var countBlockSelector = '.wc-block-components-quantity-selector__input';
	var removeBlock = '.wc-block-cart-item__remove-link';
	var subtotalText = '.wc-block-components-totals-item__label';
	var cartBtnText = '.wc-block-components-button__text';
	var processedElements = new Set();

	var updateElement = function (selector, buttonsDiv, moneyAmount, minusBlockSelector, plusBlockSelector, parentElementSelector, countBlockSelector, removeBlock, subtotalText, cartBtnText) {
			var parentElements = document.querySelectorAll(parentElementSelector);
			var targetElement = document.querySelector(selector);
			var buttons = document.querySelector(buttonsDiv);
			var count = document.querySelector(countBlockSelector);
			var subtotal = document.querySelector(subtotalText);
			var cartTexts = document.querySelectorAll(cartBtnText);
			if (targetElement && cartTexts && parentElements && count && subtotal && buttons && !processedElements.has(targetElement)) {
					processedElements.add(targetElement);
					processedElements.add(parentElements);
					processedElements.add(count);

					subtotal.textContent = 'Subtotal:';

					console.log(cartTexts);
					cartTexts.forEach(function (cartText) {
						if (cartText.textContent == 'View my cart') {
							cartText.textContent = 'View cart'
						}
						if (cartText.textContent == 'Go to checkout') {
							cartText.textContent = 'Checkout'
						}
					})
					var newDiv = document.createElement('div');
					newDiv.classList.add('bar-block');
					targetElement.insertBefore(newDiv, buttons);

					// Create a new paragraph element
					var newText = document.createElement('p');

					var progressBlock = document.createElement('div');
					progressBlock.classList.add('progress');
					targetElement.insertBefore(progressBlock, buttons);

					var bar = document.createElement('div');
					bar.classList.add('bar');
					progressBlock.appendChild(bar);
					
					function delay(ms) {
						return new Promise(resolve => setTimeout(resolve, ms));
					}
					var money = document.querySelector(moneyAmount);
					
					function updateShipping() {
						moneyContent = money.textContent;

						var matches = moneyContent.match(/([^\d]*)([\d,.]+)/);
						var matchesTrim = matches[2].trim();
						var float = parseFloat(matchesTrim.replace(',', ''));
						var cash = 1500;
						var free = cash - float;
						if (free <= 0) {
							free = 0;
						}
						var width = parseInt(100 - (free / 1500 * 100)) + "%";
						bar.style.width = width;
						var formattedNumber = free.toString();
						if (formattedNumber.length > 3) {
								formattedNumber = formattedNumber[0] + ',' + formattedNumber.slice(1);
						}
						formattedNumber = '$'+formattedNumber+'.00';
						newText.innerHTML = `Add <span class="cash">${formattedNumber}</span> to cart and get <span>free shipping!</span>`;
					}
					updateShipping();
					
					var addToCarts = document.querySelectorAll('.add_to_cart_button');
					addToCarts.forEach(function (addToCart) {
					if (addToCart) {
							delay(1000).then(() => {
								updateShipping();
							});
						}
					})
					parentElements.forEach(function (parentElement) {
					var minus = parentElement.querySelector(minusBlockSelector);
					var plus = parentElement.querySelector(plusBlockSelector);
					var remove = parentElement.querySelector(removeBlock);
					if (minus) {
							minus.addEventListener('click', function () {
								delay(1000).then(() => {
									updateShipping();
								});
							});
					}

					if (remove) {
						remove.addEventListener('click', function () {
							delay(1000).then(() => {
								updateShipping();
							});
						});
				}

					if (plus) {
							plus.addEventListener('click', function () {
								delay(1000).then(() => {
									updateShipping();
								});
							});
						}
					})
				// Append the paragraph element to the new div
				newDiv.appendChild(newText);
			}
	};

	var checkAndUpdate = function () {
			updateElement(targetSelector, buttonsDiv, moneyAmount, minusBlockSelector, plusBlockSelector, parentElementSelector, countBlockSelector, removeBlock, subtotalText, cartBtnText);
	};

	checkAndUpdate();

	var observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (mutation) {
					if (mutation.type === 'childList' && (mutation.target.matches(targetSelector) || mutation.target.querySelector(targetSelector) || mutation.target.querySelector(countBlockSelector) || mutation.target.matches(countBlockSelector))) {
							checkAndUpdate();
					}
			});
	});

	observer.observe(document.body, { childList: true, subtree: true });
});



document.addEventListener('DOMContentLoaded', function() {
	// Target element selector
	var targetElementSelector = '.wc-block-components-drawer__screen-overlay';
	// Callback function to be executed when mutations are observed
	var mutationCallback = function(mutationsList, observer) {
			for (var mutation of mutationsList) {
					if (mutation.type === 'childList') {
							// Check if the target element is added
							if (
									Array.from(mutation.addedNodes).some(
											(node) => node.matches && node.matches(targetElementSelector)
									)
							) {
									var emptyCart = document.querySelector('.wc-block-mini-cart__drawer .wp-block-woocommerce-empty-mini-cart-contents-block');
									var emptyText = document.querySelector('.wp-block-woocommerce-empty-mini-cart-contents-block > p > strong');
									var heading = document.querySelector('.wp-block-woocommerce-mini-cart-contents');
									if (heading) {
										var cartHeading = document.createElement('h3');
										cartHeading.classList.add('cart-heading');
										cartHeading.textContent = 'Shopping cart';
										heading.insertBefore(cartHeading, heading.firstChild);
									}
									if (emptyText) {
										emptyText.textContent = 'No products in the cart';
									}
									if (emptyCart) {
											var newImg = document.createElement('img');
											newImg.classList.add('cart-empty--img');
											newImg.setAttribute('src', WPJS.siteUrl+'/assets/img/side-cart.svg');
											newImg.setAttribute('alt', 'Empty cart img');
											emptyCart.insertBefore(newImg, emptyCart.firstChild);
									}
									// Perform actions for element addition
							}
					}
			}
	};

	// Options for the observer (specify what types of mutations to observe)
	var observerOptions = {
			childList: true,  // Observe changes to the child nodes
			subtree: true     // Include changes in all descendants of the target node
	};

	// Create a new observer with the specified callback and options
	var observer = new MutationObserver(mutationCallback);

	// Configure and start the observer
	observer.observe(document.body, observerOptions);
});

document.addEventListener('DOMContentLoaded', function() {
	// Target element selector
	var targetElementSelector = '.wc-block-components-drawer__close';
	// Callback function to be executed when mutations are observed
	var mutationCallback = function(mutationsList, observer) {
			for (var mutation of mutationsList) {
					if (mutation.type === 'childList') {
							// Check if the target element is added
							if (
									Array.from(mutation.addedNodes).some(
											(node) => node.matches && node.matches(targetElementSelector)
									)
							) {
									var closeButton = document.querySelector(targetElementSelector);;

										if (closeButton) {
										
											// Create a new SVG element
											var newSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
											newSvg.setAttribute("width", "24");
											newSvg.setAttribute("height", "25");
											newSvg.setAttribute("viewBox", "0 0 24 25");
											newSvg.setAttribute("fill", "none");
											newSvg.setAttribute("class", "svg");
						
											// Create a path element and set its attributes
											var newPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
											newPath.setAttribute("d", "M6.4 19.5L5 18.1L10.6 12.5L5 6.9L6.4 5.5L12 11.1L17.6 5.5L19 6.9L13.4 12.5L19 18.1L17.6 19.5L12 13.9L6.4 19.5Z");
											newPath.setAttribute("fill", "#777777");
						
											// Append the path to the new SVG
											newSvg.appendChild(newPath);
						
											// Append the new SVG to the closeButton
											closeButton.appendChild(newSvg);
										}
									
							}
					}
			}
	};

	// Options for the observer (specify what types of mutations to observe)
	var observerOptions = {
			childList: true,  // Observe changes to the child nodes
			subtree: true     // Include changes in all descendants of the target node
	};

	// Create a new observer with the specified callback and options
	var observer = new MutationObserver(mutationCallback);

	// Configure and start the observer
	observer.observe(document.body, observerOptions);
});


}(jQuery) );
