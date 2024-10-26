/* JavaScript for the Fluent skin */

// Show and hide elements

// Select the search box when clicking on the search icon
document.getElementById('p-search').getElementsByTagName('h3')[0].onclick = function(){
     document.getElementById("searchInput").focus();
}

// Toggle the search bar when clicking on the search icon
var searchIcon = document.getElementById("search-icon");
if (searchIcon) {
	var searchBox = document.getElementById("search-box");
	searchIcon.addEventListener("click", function() {
		searchBox.classList.toggle("fade-search");
	});
};

// Toggle the dropdown menu when clicking on the user icon
var userIcon = document.getElementById("user-icon");
if (userIcon) {
	var userMenu = document.getElementById("mw-user-links");
	userIcon.addEventListener("click", function() {
		userMenu.classList.toggle("fade-menu");
	});
};

// Toggle the dropdown menu when clicking on the namespaces label
var namespacesLabel = document.getElementById("p-namespaces-label");
if (namespacesLabel) {
	var namespacesMenu = document.getElementById("menu-namespaces");
	namespacesLabel.addEventListener("click", function() {
		namespacesMenu.classList.toggle("fade-menu");
	});
};

// Toggle the dropdown menu when clicking on the views label
var viewsLabel = document.getElementById("p-views-label");
if (viewsLabel) {
	var viewsMenu = document.getElementById("menu-views");
	viewsLabel.addEventListener("click", function() {
		viewsMenu.classList.toggle("fade-menu");
	});
};

// Toggle the dropdown menu when clicking on the actions label
var actionsLabel = document.getElementById("p-actions-label");
if (actionsLabel) {
	var actionsMenu = document.getElementById("menu-actions");
	actionsLabel.addEventListener("click", function() {
		actionsMenu.classList.toggle("fade-menu");
	});
};

// Hide any of the above if they're not selected
window.onclick = function(event) {
	if (searchIcon) {
	    if (!(event.target.closest('#search-box') || event.target.closest('#search-icon') || event.target.closest('.suggestions')) && searchBox.classList.contains("fade-search")) {
		searchBox.classList.toggle("fade-search");
	    }
	}
	if (userIcon) {
	    if (!(event.target.closest('#mw-user-links') || event.target.closest('#user-icon')) && userMenu.classList.contains("fade-menu")) {
		userMenu.classList.toggle("fade-menu");
	    }
	}
	if (namespacesLabel) {
	    if (!(event.target.closest('#menu-namespaces') || event.target.closest('#p-namespaces-label')) && namespacesMenu.classList.contains("fade-menu")) {
		namespacesMenu.classList.toggle("fade-menu");
	    }
	}
	if (viewsLabel) {
	    if (!(event.target.closest('#menu-views') || event.target.closest('#p-views-label')) && viewsMenu.classList.contains("fade-menu")) {
		viewsMenu.classList.toggle("fade-menu");
	    }
	}
	if (actionsLabel) {
	    if (!(event.target.closest('#menu-actions') || event.target.closest('#p-actions-label')) && actionsMenu.classList.contains("fade-menu")) {
		actionsMenu.classList.toggle("fade-menu");
	    }
	}
}

// Toggle the sidebar on mobile when clicking on the actions label
var expandCollapseButton = document.getElementById("expand-collapse");
if (expandCollapseButton) {
	var siteWrapper = document.getElementById("mw-wrapper");
	expandCollapseButton.addEventListener("click", function() {
		siteWrapper.classList.toggle("expanded-sidebar");
	});
};

// Dark mode toggle
var darkModeToggle = document.getElementById("a-dark-toggle");
if (darkModeToggle) {
	darkModeToggle.addEventListener("click", function() {
		var currentTheme = localStorage.getItem('mode');
		if (currentTheme == "dark") {
			setTheme('light');
			document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode on';
			return;
		}
		setTheme('dark');
		document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode off';
	});
};
function setTheme(themeName) {
  localStorage.setItem('mode', themeName);
  document.documentElement.setAttribute('data-theme', themeName);
};
const theme = localStorage.getItem('mode');
if (theme) {
	setTheme(theme);
	if (theme == 'light') {
		document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode on';
	} else if (theme == 'dark') {
		document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode off';
	}
} else {
	const prefersLightTheme = window.matchMedia('(prefers-color-scheme: light)');
	if (window.matchMedia('(prefers-color-scheme: light)')) {
		setTheme('light');
		document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode on';
	} else if (window.matchMedia('(prefers-color-scheme: dark)')) {
		setTheme('dark');
		document.getElementById('a-dark-toggle').innerHTML = 'Turn dark mode off';
	} else {
		document.getElementById('a-dark-toggle').style.display = 'none';
	};
};
