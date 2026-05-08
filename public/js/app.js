// ========== Navbar Scroll Effect ==========
var navbar = document.getElementById('navbar');
window.addEventListener('scroll', function() {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
}, { passive: true });

// ========== Mobile Navigation Drawer ==========
(function() {
    var btn       = document.getElementById('navToggle');
    var drawer    = document.getElementById('navDrawer');
    var overlay   = document.getElementById('navOverlay');
    var closeBtn  = document.getElementById('navDrawerClose');
    var drawerMenu = document.getElementById('navDrawerMenu');
    if (!btn || !drawer) return;

    function openDrawer() {
        drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
        btn.classList.add('active');
        btn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
        btn.classList.remove('active');
        btn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    // CLICK — single event, fires reliably on both desktop & mobile on tap release
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (drawer.classList.contains('active')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeDrawer();
    });

    if (overlay) overlay.addEventListener('click', closeDrawer);

    // Close drawer when any menu link is clicked
    if (drawerMenu) {
        var links = drawerMenu.querySelectorAll('a');
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', closeDrawer);
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && drawer.classList.contains('active')) {
            closeDrawer();
        }
    });

    document.addEventListener('click', function(e) {
        if (drawer.classList.contains('active') &&
            !drawer.contains(e.target) &&
            !btn.contains(e.target)) {
            closeDrawer();
        }
    });
})();

// ========== Scroll Animations (Intersection Observer) ==========
var animatedElements = document.querySelectorAll('.animate-on-scroll');
if (animatedElements.length > 0) {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    animatedElements.forEach(function(el) { observer.observe(el); });
}

// ========== Counter Animation ==========
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
    var statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    statNumbers.forEach(function(el) { statsObserver.observe(el); });
}

// ========== Smooth scroll for anchor links ==========
document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
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