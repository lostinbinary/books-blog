window.addEventListener("load", function () {
  const boxes = document.querySelectorAll(".coldeddd-boxes-list>div");
  boxes.forEach((item, idx) => {
    let dataLink = item.getAttribute("data-link");
    let img = item.querySelector("a");
    let title = item.querySelector("div").querySelector("a");
    img.href = dataLink;
    title.href = dataLink;
  });
  // image appear
  const images = document.querySelectorAll("[data-src]");

  function preloadImage(img) {
    const src = img.getAttribute("data-src");
    if (!src) {
      return;
    }
    img.src = src;
  }
  const imgOptions = {};
  const imgObserver = new IntersectionObserver((entries, imgObserver) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      } else {
        preloadImage(entry.target);
        imgObserver.unobserve(entry.target);
      }
    });
  }, imgOptions);
  images.forEach((image) => {
    imgObserver.observe(image);
  });
});

document.getElementById("search").addEventListener("submit", myFunction);

function myFunction(e) {
  e.preventDefault();
  let input = document.getElementById("search_input").value;
  input = input.replaceAll(' ', '-');
  open('/s/'+input,'_self');
}