window.addEventListener("load", () => {
  const btn = document.querySelector(".timersss-single-image>div button");
  const iframe = document.querySelector(".timersss-iframee");
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
