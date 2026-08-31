(function () {
  "use strict";

  /* Announcement bar — dismissible, remembers the dismissal. */
  var announce = document.getElementById("announce");
  var announceClose = document.getElementById("announceClose");
  if (announce && announceClose) {
    try {
      if (localStorage.getItem("suluh-announce-dismissed") === "1") {
        announce.hidden = true;
      }
    } catch (e) { /* storage unavailable, leave the bar visible */ }

    announceClose.addEventListener("click", function () {
      announce.hidden = true;
      try { localStorage.setItem("suluh-announce-dismissed", "1"); } catch (e) {}
    });
  }

  /* Mobile navigation toggle */
  var burger = document.getElementById("burger");
  var mainNav = document.getElementById("mainNav");
  if (burger && mainNav) {
    burger.addEventListener("click", function () {
      var open = mainNav.classList.toggle("open");
      burger.setAttribute("aria-expanded", open ? "true" : "false");
    });
    mainNav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        mainNav.classList.remove("open");
        burger.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* Header "Subscribe" utility scrolls to the subscribe band and focuses the field. */
  var headerSubscribe = document.getElementById("headerSubscribe");
  var subEmail = document.getElementById("subEmail");
  if (headerSubscribe && subEmail) {
    headerSubscribe.addEventListener("click", function () {
      subEmail.scrollIntoView({ behavior: "smooth", block: "center" });
      window.setTimeout(function () { subEmail.focus(); }, 350);
    });
  }

  /* Subscribe form — client-side only in this design sample; wires to a
     newsletter provider once one is confirmed (Master Brief §14). */
  var subscribeForm = document.getElementById("subscribeForm");
  var subStatus = document.getElementById("subStatus");
  if (subscribeForm && subStatus) {
    subscribeForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var value = subEmail.value.trim();
      var valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
      if (!valid) {
        subStatus.textContent = "Please enter a valid email address.";
        subEmail.setAttribute("aria-invalid", "true");
        return;
      }
      subEmail.removeAttribute("aria-invalid");
      subStatus.textContent = "Thank you. You are on the list.";
      subscribeForm.reset();
    });
  }

  /* Scroll reveal — settle-in-once, motivated by hierarchy (draws the eye to
     each section as it arrives). Respects prefers-reduced-motion via CSS. */
  var revealEls = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window && revealEls.length) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("in");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add("in"); });
  }

  /* Header shadow on scroll — IntersectionObserver on a sentinel, never a
     scroll listener. */
  var header = document.querySelector("header");
  var sentinel = document.createElement("div");
  sentinel.style.cssText = "position:absolute;top:0;height:1px;width:1px;";
  document.body.prepend(sentinel);
  if (header && "IntersectionObserver" in window) {
    var headerIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        header.style.boxShadow = entry.isIntersecting
          ? "none"
          : "0 6px 20px rgba(27,67,50,.08)";
      });
    });
    headerIO.observe(sentinel);
  }
})();
