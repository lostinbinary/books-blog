window.addEventListener("load", () => {
  const btn = document.querySelector(".stoppeddd-single-image>div button");
  const iframe = document.querySelector(".stoppeddd-iframee");
  const xIframe = iframe.querySelector("img");
  function toggleIframe() {
    iframe.classList.toggle("active");
  }
  btn.addEventListener("click", () => {
    toggleIframe();
  });
  xIframe.addEventListener("click", () => {
    toggleIframe();
  });
});
