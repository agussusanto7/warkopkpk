/* ============================================
   WARKOP KPK - JAVASCRIPT
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ============================================
     NAVBAR SCROLL EFFECT
     ============================================ */
  const navbar = document.getElementById('navbar');

  function handleNavbarScroll() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleNavbarScroll, { passive: true });
  handleNavbarScroll();

  /* ============================================
     MOBILE NAVIGATION DRAWER
     ============================================ */
  const navToggle      = document.getElementById('navToggle');
  const navDrawer      = document.getElementById('navDrawer');
  const navDrawerClose = document.getElementById('navDrawerClose');
  const navOverlay     = document.getElementById('navOverlay');
  const navDrawerMenu  = document.getElementById('navDrawerMenu');

  function openDrawer() {
    navDrawer.classList.add('active');
    navOverlay.classList.add('active');
    navToggle.classList.add('active');
    navToggle.setAttribute('aria-expanded', 'true');
    navDrawer.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    navDrawer.classList.remove('active');
    navOverlay.classList.remove('active');
    navToggle.classList.remove('active');
    navToggle.setAttribute('aria-expanded', 'false');
    navDrawer.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  // pointerdown fires for BOTH touch and mouse — most reliable for mobile tap
  navToggle.addEventListener('pointerdown', function (e) {
    e.preventDefault();
    if (navDrawer.classList.contains('active')) {
      closeDrawer();
    } else {
      openDrawer();
    }
  });

  navDrawerClose.addEventListener('click', closeDrawer);
  navOverlay.addEventListener('click', closeDrawer);

  // Close drawer when any menu link is clicked
  navDrawerMenu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      closeDrawer();
    });
  });

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && navDrawer.classList.contains('active')) {
      closeDrawer();
    }
  });

  /* ============================================
     SCROLL ANIMATIONS (Intersection Observer)
     ============================================ */
  var animatedElements = document.querySelectorAll('.animate-on-scroll');

  if (animatedElements.length > 0) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    animatedElements.forEach(function (el) {
      observer.observe(el);
    });
  }

  /* ============================================
     COUNTER ANIMATION FOR STATS
     ============================================ */
  var statNumbers = document.querySelectorAll('.stat-number');

  if (statNumbers.length > 0) {
    function animateCounter(el) {
      var target   = parseInt(el.getAttribute('data-count'), 10);
      var duration = 1800;
      var start    = performance.now();

      function update(now) {
        var elapsed  = now - start;
        var progress = Math.min(elapsed / duration, 1);
        var eased    = 1 - Math.pow(1 - progress, 4);
        el.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(update);
      }

      requestAnimationFrame(update);
    }

    var statsObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          statsObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    statNumbers.forEach(function (el) {
      statsObserver.observe(el);
    });
  }

  /* ============================================
     SMOOTH SCROLL FOR ANCHOR LINKS
     ============================================ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var targetId = this.getAttribute('href');
      if (targetId === '#') return;
      var target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        var navHeight      = navbar.offsetHeight;
        var targetPosition = target.getBoundingClientRect().top + window.scrollY - navHeight;
        window.scrollTo({ top: targetPosition, behavior: 'smooth' });
      }
    });
  });

  /* ============================================
     MENU FILTER (if on menu page)
     ============================================ */
  var filterBtns      = document.querySelectorAll('.filter-btn');
  var menuCategories  = document.querySelectorAll('.menu-category');

  if (filterBtns.length > 0 && menuCategories.length > 0) {
    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterBtns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        var filter = btn.getAttribute('data-filter');
        menuCategories.forEach(function (cat) {
          if (filter === 'all' || cat.getAttribute('data-category') === filter) {
            cat.style.display = 'block';
            cat.style.animation = 'fadeInUp 0.4s ease forwards';
          } else {
            cat.style.display = 'none';
          }
        });
      });
    });
  }

  /* ============================================
     GALLERY FILTER (if on gallery page)
     ============================================ */
  var galleryBtns  = document.querySelectorAll('.gallery-filter-btn');
  var galleryItems = document.querySelectorAll('.gallery-item');

  if (galleryBtns.length > 0 && galleryItems.length > 0) {
    galleryBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        galleryBtns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        var filter = btn.getAttribute('data-filter');
        galleryItems.forEach(function (item) {
          if (filter === 'all' || item.getAttribute('data-category') === filter) {
            item.style.display = 'block';
            item.style.animation = 'fadeInUp 0.4s ease forwards';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

});