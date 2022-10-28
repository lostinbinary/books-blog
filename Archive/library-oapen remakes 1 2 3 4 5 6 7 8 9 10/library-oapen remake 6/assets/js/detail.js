const iframeBtn = document.querySelector(".somehowww-iframe-btn");
const iframe = document.querySelector(".somehowww-iframe iframe");
const iframeCircle = document.querySelector(".somehowww-circles");
const link = iframeBtn.getAttribute("data-link");
iframeBtn.addEventListener("click", function () {
  iframeCircle.style.display = "block";
  iframe.src = link;
  iframeBtn.style.display = "none";
  setTimeout(function () {
    iframeCircle.style.display = "none";
  }, 10000);
});
