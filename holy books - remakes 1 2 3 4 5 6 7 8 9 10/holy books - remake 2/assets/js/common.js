window.addEventListener("load", function () {
  const boxes = document.querySelectorAll(".role-modelll-boxes-list>div");
  const viewBtn = document.querySelectorAll(".role-modelll-view-book");
  const splinner = document.querySelector(".role-modelll-book-spinn");
  const pdfPop = document.querySelector(".role-modelll-book-pop");
  const iframePop = document.querySelector(".role-modelll-book-pop iframe");
  const iframePopBody = document.querySelector(".role-modelll-book-pop>div>div>div");
  boxes.forEach((item, idx) => {
    let dataLink = item.getAttribute("data-link");
    let img = item.querySelectorAll("a");
    img.forEach((item, idx) => {
      item.href = dataLink;
    });
  });
  pdfPop.addEventListener("click", () => {
    pdfPop.classList.remove("active");
  });
  iframePopBody.addEventListener("click", (e) => {
    e.stopPropagation();
  });
  viewBtn.forEach((item, idx) => {
    item.addEventListener("click", (e) => {
      let currLink = e.currentTarget.getAttribute("data-pdf");
      iframePop.src = currLink;
      splinner.classList.add("active");
      this.setTimeout(() => {
        splinner.classList.remove("active");
        pdfPop.classList.add("active");
      }, 10000);
    });
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