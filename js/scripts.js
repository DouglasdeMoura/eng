(function () {
  'use strict';
  var body = document.body;
  var drawer = document.querySelector('.main-navigation');
  var navbar = document.querySelector('.site-header');
  var main = document.querySelector('.site-wrapper');
  var toggler = document.querySelector('.menu-toggle');
  var close = document.querySelector('.close-menu');
  var search = document.querySelector('.display-search');
  var searchClose = document.querySelector('.close-site-search');
  var searchform = document.querySelector('.site-search');
 
  function closeMenu() {
    body.classList.remove('open');
    navbar.classList.remove('open');
    drawer.classList.remove('open');
  }

  function toggleMenu() {
    body.classList.toggle('open');
    navbar.classList.toggle('open');
    drawer.classList.toggle('open');
    drawer.classList.add('opened');
  }

  function closeSearch() {
    searchform.classList.remove('open');
    document.querySelector('.search').classList.remove('hide');
    if (document.activeElement != document.body) document.activeElement.blur();
  }

  function toggleSearch() {
    searchform.classList.toggle('open');
    searchform.classList.add('opened');
    document.querySelector('.search-field').focus();
  }

  main.addEventListener('click', closeMenu);
  close.addEventListener('click', closeMenu);
  toggler.addEventListener('click', toggleMenu);
  drawer.addEventListener('click', function (event) {
    if (event.target.nodeName === 'A' || event.target.nodeName === 'LI') {
      closeMenu();
    }
  });

  search.addEventListener('click', toggleSearch);
  searchClose.addEventListener('click', closeSearch);
  main.addEventListener('click', closeSearch);

})();
