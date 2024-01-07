/**
 * File navigation.js.
 *
 * navigation support for dropdown menus.
 */
( function() {
	let navMenu = document.getElementById('primary');

	// Check if the navMenu element exists
	if (navMenu) {
		// Find all <li> elements inside the navMenu
		let liElements = navMenu.querySelectorAll('li');

		// Loop through each <li> element
		liElements.forEach(function(li) {
				// Find the <a> element inside the <li>
				let aElement = li.querySelector('a');

				// Check if the <a> element exists and its text content is "Pages"
				if (aElement && aElement.textContent.trim() === 'Pages') {
					let subMenu = aElement.parentNode.querySelector('ul.sub-menu');
						aElement.addEventListener('click', function(e) {
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
		});
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


}() );
