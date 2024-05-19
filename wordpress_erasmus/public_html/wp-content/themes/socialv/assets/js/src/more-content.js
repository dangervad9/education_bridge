"use strict";
let desc = document.querySelectorAll('.description-content');
desc.forEach(function(el) {
  el.classList.toggle('showContent');
  el.classList.toggle('hideContent');
});
let desc_panel_height = countLines(desc[0]);
desc.forEach(function(el) {
  el.classList.toggle('showContent');
  el.classList.toggle('hideContent');
});
if (desc_panel_height > 3) {
  desc.forEach(function(el) {
    el.classList.add('hideContent');
    el.nextElementSibling.classList.remove('hideContent');
    el.nextElementSibling.classList.add('show-more');
    el.nextElementSibling.style.display = 'block';
    el.nextElementSibling.addEventListener('click', function() {
      let btn = this.querySelector('a');
      desc.forEach(function(el) {
        el.classList.toggle('showContent');
        el.classList.toggle('hideContent');
      });
      if (!desc[0].classList.contains('showContent')) {
        btn.textContent = btn.dataset.showmore;
      } else {
        btn.textContent = btn.dataset.showless;
      }
    });
  });
} else {
  desc.forEach(function(el) {
    el.classList.remove('showContent');
    el.nextElementSibling.classList.add('hideContent');
    el.nextElementSibling.style.display = 'none';
  });
}

function countLines(el) {
  return Math.round(Number(el.offsetHeight / parseInt(getComputedStyle(el).lineHeight.slice(0, -2))));
}
