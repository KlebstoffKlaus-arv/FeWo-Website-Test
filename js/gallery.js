(function () {
  "use strict";

  var galleries = document.querySelectorAll("[data-gallery]");
  if (!galleries.length) return;

  var lightbox = document.getElementById("lightbox");
  if (!lightbox) return;

  var imgEl = lightbox.querySelector(".lightbox__figure img");
  var captionEl = lightbox.querySelector(".lightbox__caption");
  var closeBtn = lightbox.querySelector(".lightbox__close");
  var prevBtn = lightbox.querySelector(".lightbox__nav--prev");
  var nextBtn = lightbox.querySelector(".lightbox__nav--next");

  var items = [];
  var currentIndex = 0;
  var lastFocused = null;

  galleries.forEach(function (gallery) {
    var buttons = gallery.querySelectorAll(".gallery__item");
    buttons.forEach(function (btn) {
      var index = items.length;
      items.push({
        src: btn.getAttribute("data-full") || btn.querySelector("img").src,
        alt: btn.querySelector("img").alt || ""
      });
      btn.addEventListener("click", function () {
        openLightbox(index);
      });
    });
  });

  function openLightbox(index) {
    currentIndex = index;
    updateImage();
    lightbox.hidden = false;
    lastFocused = document.activeElement;
    closeBtn.focus();
    document.body.style.overflow = "hidden";
  }

  function closeLightbox() {
    lightbox.hidden = true;
    document.body.style.overflow = "";
    if (lastFocused) lastFocused.focus();
  }

  function updateImage() {
    var item = items[currentIndex];
    imgEl.src = item.src;
    imgEl.alt = item.alt;
    captionEl.textContent = item.alt;
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    updateImage();
  }

  function showNext() {
    currentIndex = (currentIndex + 1) % items.length;
    updateImage();
  }

  closeBtn.addEventListener("click", closeLightbox);
  prevBtn.addEventListener("click", showPrev);
  nextBtn.addEventListener("click", showNext);

  lightbox.addEventListener("click", function (e) {
    if (e.target === lightbox) closeLightbox();
  });

  document.addEventListener("keydown", function (e) {
    if (lightbox.hidden) return;
    if (e.key === "Escape") closeLightbox();
    if (e.key === "ArrowLeft") showPrev();
    if (e.key === "ArrowRight") showNext();
  });
})();
