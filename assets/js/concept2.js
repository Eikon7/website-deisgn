(function () {
  "use strict";
  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* Header solidifies after leaving the hero — IntersectionObserver on the
     hero itself, never a scroll listener. */
  var header = document.getElementById("c2Header");
  var hero = document.getElementById("c2Hero");
  if (header && hero && "IntersectionObserver" in window) {
    new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          header.classList.toggle("solid", !entry.isIntersecting || entry.intersectionRatio < 0.7);
        });
      },
      { threshold: [0, 0.7] }
    ).observe(hero);
  }

  /* Hero kinetic headline — reveals shortly after load. */
  var headline = document.getElementById("c2Headline");
  if (headline) {
    if (reduceMotion) {
      headline.classList.add("in");
      hero && hero.classList.add("in");
    } else {
      window.requestAnimationFrame(function () {
        setTimeout(function () {
          headline.classList.add("in");
          hero && hero.classList.add("in");
        }, 120);
      });
    }
  }

  /* Generic scroll reveal for section content. */
  var revealEls = document.querySelectorAll(".reveal2");
  if ("IntersectionObserver" in window && revealEls.length) {
    var revealIO = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("in");
            revealIO.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach(function (el) { revealIO.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add("in"); });
  }

  /* The idea — flame line draws in once, and the closing statement fades in
     together (same trigger, one motivated moment). */
  var idea = document.getElementById("idea");
  if (idea && "IntersectionObserver" in window) {
    var ideaIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          idea.classList.add("in");
          ideaIO.unobserve(idea);
        }
      });
    }, { threshold: 0.35 });
    ideaIO.observe(idea);
  } else if (idea) {
    idea.classList.add("in");
  }

  /* Continuity timeline — the connecting line fills in once both points are visible. */
  var timeline = document.querySelector(".timeline2");
  if (timeline && "IntersectionObserver" in window) {
    var tlIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          timeline.classList.add("in");
          tlIO.unobserve(timeline);
        }
      });
    }, { threshold: 0.3 });
    tlIO.observe(timeline);
  } else if (timeline) {
    timeline.classList.add("in");
  }

  /* Impact numbers count up once, when the strip enters view. Motivated:
     draws the eye to the evidence figures the whole section exists to show. */
  var numEls = document.querySelectorAll(".num-item .n");
  function countUp(el) {
    var target = parseInt(el.getAttribute("data-count"), 10) || 0;
    var suffix = el.getAttribute("data-suffix") || "";
    if (reduceMotion || target <= 20) {
      el.textContent = target + suffix;
      return;
    }
    var start = null;
    var duration = 900;
    function step(ts) {
      if (start === null) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(eased * target) + suffix;
      if (progress < 1) window.requestAnimationFrame(step);
    }
    window.requestAnimationFrame(step);
  }
  if (numEls.length && "IntersectionObserver" in window) {
    var numIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          countUp(entry.target);
          numIO.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });
    numEls.forEach(function (el) { numIO.observe(el); });
  } else {
    numEls.forEach(function (el) { countUp(el); });
  }

  /* Mobile drawer */
  var burger = document.getElementById("c2Burger");
  var drawer = document.getElementById("c2Drawer");
  var drawerClose = document.getElementById("c2DrawerClose");
  function closeDrawer() {
    drawer.classList.remove("open");
    burger.setAttribute("aria-expanded", "false");
  }
  if (burger && drawer) {
    burger.addEventListener("click", function () {
      drawer.classList.add("open");
      burger.setAttribute("aria-expanded", "true");
    });
    drawerClose.addEventListener("click", closeDrawer);
    drawer.querySelectorAll("a").forEach(function (a) { a.addEventListener("click", closeDrawer); });
  }

  /* Header "Subscribe" jumps to the closing form. */
  var subBtn = document.getElementById("c2SubscribeBtn");
  var emailInput = document.getElementById("c2Email");
  if (subBtn && emailInput) {
    subBtn.addEventListener("click", function () {
      emailInput.scrollIntoView({ behavior: "smooth", block: "center" });
      setTimeout(function () { emailInput.focus(); }, 350);
    });
  }

  /* Subscribe form — client-side only in this design concept. */
  var form = document.getElementById("c2Form");
  var status = document.getElementById("c2Status");
  if (form && status) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim());
      if (!valid) {
        status.textContent = "Please enter a valid email address.";
        return;
      }
      status.textContent = "Thank you. You are on the list.";
      form.reset();
    });
  }

  /* Contact page form — client-side only in this design concept. */
  var contactForm = document.getElementById("c2ContactForm");
  var contactStatus = document.getElementById("ccStatus");
  if (contactForm && contactStatus) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var name = document.getElementById("ccName");
      var email = document.getElementById("ccEmail");
      var message = document.getElementById("ccMessage");
      var validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim());
      if (!name.value.trim() || !validEmail || !message.value.trim()) {
        contactStatus.textContent = "Please fill in your name, a valid email, and a message.";
        return;
      }
      contactStatus.textContent = "Thank you. We'll be in touch shortly.";
      contactForm.reset();
    });
  }

  /* Research library — filter chips. */
  var chips = document.querySelectorAll(".filters .chip");
  var pubRows = document.querySelectorAll(".pubrow");
  var pubEmpty = document.getElementById("pubEmpty");
  if (chips.length && pubRows.length) {
    chips.forEach(function (chip) {
      chip.addEventListener("click", function () {
        chips.forEach(function (c) { c.classList.remove("on"); });
        chip.classList.add("on");
        var type = chip.dataset.type;
        var visible = 0;
        pubRows.forEach(function (row) {
          var show = type === "All" || row.dataset.type === type;
          row.classList.toggle("hidden", !show);
          if (show) visible++;
        });
        if (pubEmpty) pubEmpty.hidden = visible !== 0;
      });
    });
  }

  /* Stories — filter chips (separate list from the research library so the
     two pages' filters never cross-talk). */
  var storyChips = document.querySelectorAll(".story-filters .chip");
  var storyCards = document.querySelectorAll(".story-card");
  var storyEmpty = document.getElementById("storyEmpty");
  if (storyChips.length && storyCards.length) {
    storyChips.forEach(function (chip) {
      chip.addEventListener("click", function () {
        storyChips.forEach(function (c) { c.classList.remove("on"); });
        chip.classList.add("on");
        var type = chip.dataset.type;
        var visible = 0;
        storyCards.forEach(function (card) {
          var show = type === "All" || card.dataset.type === type;
          card.classList.toggle("hidden", !show);
          if (show) visible++;
        });
        if (storyEmpty) storyEmpty.hidden = visible !== 0;
      });
    });
  }

  /* Research library — gated PDF download. Client-side only in this
     design concept: the name/email are validated but not sent anywhere;
     wiring this to a real mailing list is a backend integration step. */
  var dlOverlay = document.getElementById("dlOverlay");
  if (dlOverlay) {
    var dlForm = document.getElementById("dlForm");
    var dlStatus = document.getElementById("dlStatus");
    var dlDocTitle = document.getElementById("dlDocTitle");
    var dlClose = document.getElementById("dlClose");
    var dlName = document.getElementById("dlName");
    var dlEmail = document.getElementById("dlEmail");
    var pendingFile = null;

    function openDlModal(file, title) {
      pendingFile = file;
      dlDocTitle.textContent = title;
      dlStatus.textContent = "";
      dlForm.reset();
      dlOverlay.classList.add("open");
      dlName.focus();
    }
    function closeDlModal() {
      dlOverlay.classList.remove("open");
    }

    document.querySelectorAll(".pub-dl").forEach(function (btn) {
      btn.addEventListener("click", function () {
        openDlModal(btn.dataset.file, btn.dataset.title);
      });
    });
    dlClose.addEventListener("click", closeDlModal);
    dlOverlay.addEventListener("click", function (e) {
      if (e.target === dlOverlay) closeDlModal();
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && dlOverlay.classList.contains("open")) closeDlModal();
    });

    dlForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(dlEmail.value.trim());
      if (!dlName.value.trim() || !validEmail) {
        dlStatus.textContent = "Please enter your name and a valid email address.";
        return;
      }
      var a = document.createElement("a");
      a.href = pendingFile;
      a.download = "";
      document.body.appendChild(a);
      a.click();
      a.remove();
      dlStatus.textContent = "Thank you. Your download should begin automatically.";
      setTimeout(closeDlModal, 1400);
    });
  }
})();
