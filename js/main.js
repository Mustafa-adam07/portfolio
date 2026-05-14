/* ===================================================
   main.js — Mustafa Adam Portfolio
   Handles: dark mode, nav, scroll, counters,
            skill bars, project AJAX, contact form
=================================================== */

// ── DOM READY ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  initDarkMode();
  initNav();
  initScrollReveal();
  initCounters();
  initSkillBars();
  loadProjects();
  initProjectFilter();
  initContactForm();
  setFooterYear();
  initImageSlider();
});

// ── DARK MODE TOGGLE ───────────────────────────────
function initDarkMode() {
  const toggle = document.getElementById('darkModeToggle');
  const body   = document.body;

  // Load preference (cookie)
  const saved = getCookie('colorMode');
  if (saved === 'light') body.classList.add('light-mode');

  toggle.addEventListener('click', () => {
    body.classList.toggle('light-mode');
    const mode = body.classList.contains('light-mode') ? 'light' : 'dark';
    setCookie('colorMode', mode, 365);
    toggle.querySelector('.toggle-icon').textContent = mode === 'light' ? '●' : '◐';
  });
}

// ── NAVIGATION ─────────────────────────────────────
function initNav() {
  const navbar    = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');

  // Scroll shadow
  window.addEventListener('scroll', () => {
    navbar.style.boxShadow = window.scrollY > 40
      ? '0 4px 24px rgba(0,0,0,0.4)'
      : 'none';
  }, { passive: true });

  // Mobile menu
  hamburger.addEventListener('click', () => {
    navbar.classList.toggle('nav-open');
  });

  // Close mobile menu on link click
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => navbar.classList.remove('nav-open'));
  });

  // Active link on scroll
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-links a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(sec => {
      if (window.scrollY >= sec.offsetTop - 200) current = sec.getAttribute('id');
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === `#${current}`) link.classList.add('active');
    });
  }, { passive: true });
}

// ── SCROLL REVEAL ──────────────────────────────────
function initScrollReveal() {
  const els = document.querySelectorAll('section, .skill-card, .project-card');
  els.forEach(el => el.classList.add('reveal'));

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  els.forEach(el => observer.observe(el));
}

// ── ANIMATED COUNTERS ──────────────────────────────
function initCounters() {
  const nums = document.querySelectorAll('.stat-num');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el     = entry.target;
      const target = parseInt(el.dataset.target, 10);
      let count    = 0;
      const step   = Math.ceil(target / 40);
      const timer  = setInterval(() => {
        count += step;
        if (count >= target) { count = target; clearInterval(timer); }
        el.textContent = count;
      }, 40);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });

  nums.forEach(n => observer.observe(n));
}

// ── SKILL BARS ─────────────────────────────────────
function initSkillBars() {
  const fills = document.querySelectorAll('.skill-fill');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      el.style.width = el.dataset.width + '%';
      observer.unobserve(el);
    });
  }, { threshold: 0.3 });

  fills.forEach(f => observer.observe(f));
}

// ── LOAD PROJECTS VIA AJAX ─────────────────────────
function loadProjects(filter = 'all') {
  const grid = document.getElementById('projectsGrid');
  grid.innerHTML = `
    <div class="loading-spinner">
      <div class="spinner"></div>
      <p>Loading projects...</p>
    </div>`;

  fetch(`php/get_projects.php?filter=${encodeURIComponent(filter)}`)
    .then(res => res.json())
    .then(data => renderProjects(data))
    .catch(() => renderProjects(getFallbackProjects(filter)));
}

function renderProjects(projects) {
  const grid = document.getElementById('projectsGrid');
  if (!projects.length) {
    grid.innerHTML = '<p style="color:var(--text-muted);font-size:.85rem">No projects found.</p>';
    return;
  }

  grid.innerHTML = projects.map(p => `
    <div class="project-card reveal" data-category="${p.category}">
      <div class="project-img">
        <span>${p.emoji || '💻'}</span>
      </div>
      <div class="project-body">
        <div class="project-tags">
          ${p.tags.split(',').map(t => `<span class="project-tag">${t.trim()}</span>`).join('')}
        </div>
        <h3>${escapeHtml(p.title)}</h3>
        <p>${escapeHtml(p.description)}</p>
        <div class="project-links">
          ${p.github_url ? `<a class="project-link" href="${p.github_url}" target="_blank" rel="noopener">GitHub ↗</a>` : ''}
          ${p.live_url   ? `<a class="project-link" href="${p.live_url}"   target="_blank" rel="noopener">Live ↗</a>`   : ''}
        </div>
      </div>
    </div>
  `).join('');

  // Re-trigger scroll reveal on new cards
  document.querySelectorAll('.project-card.reveal').forEach(el => {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: 0.1 });
    obs.observe(el);
  });
}

// Fallback if PHP not running
function getFallbackProjects(filter) {
  const all = [
    { title: 'DevConnect Platform', description: 'A full-stack social platform for developers to share projects and collaborate in real-time.', tags: 'PHP, MySQL, JavaScript', category: 'fullstack', emoji: '🚀', github_url: '#', live_url: '#' },
    { title: 'TaskFlow App', description: 'A Kanban-style task manager with drag-and-drop functionality and team collaboration features.', tags: 'JavaScript, CSS Grid, AJAX', category: 'web', emoji: '📋', github_url: '#', live_url: '#' },
    { title: 'ShopEase E-Commerce', description: 'A complete online store with cart, checkout, admin dashboard, and MySQL inventory management.', tags: 'PHP, MySQL, HTML, CSS', category: 'fullstack', emoji: '🛒', github_url: '#', live_url: '#' },
    { title: 'REST API Server', description: 'A RESTful API built in PHP with JWT authentication, rate limiting, and full CRUD operations.', tags: 'PHP, MySQL, JSON', category: 'backend', emoji: '⚙️', github_url: '#', live_url: '#' },
    { title: 'Weather Dashboard', description: 'Real-time weather app using Fetch API, geolocation, and dynamic chart rendering.', tags: 'JavaScript, CSS, API', category: 'web', emoji: '🌤', github_url: '#', live_url: '#' },
    { title: 'Blog CMS', description: 'A content management system with WYSIWYG editor, categories, and admin authentication.', tags: 'PHP, MySQL, JavaScript', category: 'backend', emoji: '✍️', github_url: '#', live_url: '#' },
  ];
  return filter === 'all' ? all : all.filter(p => p.category === filter);
}

// ── PROJECT FILTER ─────────────────────────────────
function initProjectFilter() {
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      loadProjects(this.dataset.filter);
    });
  });
}

// ── CONTACT FORM ────────────────────────────────────
function initContactForm() {
  const form      = document.getElementById('contactForm');
  const statusDiv = document.getElementById('formStatus');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearErrors();

    const name    = document.getElementById('fname');
    const email   = document.getElementById('femail');
    const subject = document.getElementById('fsubject');
    const message = document.getElementById('fmessage');

    let valid = true;

    // Validation
    if (!name.value.trim() || name.value.trim().length < 2) {
      showError('nameError', name, 'Please enter your full name (at least 2 characters).');
      valid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailRegex.test(email.value)) {
      showError('emailError', email, 'Please enter a valid email address.');
      valid = false;
    }

    if (!subject.value.trim() || subject.value.trim().length < 3) {
      showError('subjectError', subject, 'Subject must be at least 3 characters.');
      valid = false;
    }

    if (!message.value.trim() || message.value.trim().length < 10) {
      showError('messageError', message, 'Message must be at least 10 characters.');
      valid = false;
    }

    if (!valid) return;

    // Submit via AJAX
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.querySelector('.btn-text').style.display   = 'none';
    submitBtn.querySelector('.btn-loader').style.display = 'inline';
    submitBtn.disabled = true;

    const formData = new FormData(form);

    try {
      const res  = await fetch('php/contact.php', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.success) {
        showStatus('Message sent! I\'ll get back to you soon. ✓', 'success');
        form.reset();
      } else {
        showStatus(data.message || 'Something went wrong. Please try again.', 'error');
      }
    } catch {
      // Fallback if PHP not running
      showStatus('Message received! (Note: configure PHP to save to database.) ✓', 'success');
      form.reset();
    } finally {
      submitBtn.querySelector('.btn-text').style.display   = 'inline';
      submitBtn.querySelector('.btn-loader').style.display = 'none';
      submitBtn.disabled = false;
    }
  });

  function showError(id, input, msg) {
    document.getElementById(id).textContent = msg;
    input.classList.add('error');
    input.focus();
  }

  function clearErrors() {
    document.querySelectorAll('.form-error').forEach(e => e.textContent = '');
    document.querySelectorAll('.form-group input, .form-group textarea')
      .forEach(i => i.classList.remove('error'));
    statusDiv.className = 'form-status';
    statusDiv.textContent = '';
  }

  function showStatus(msg, type) {
    statusDiv.textContent  = msg;
    statusDiv.className    = `form-status ${type}`;
  }
}

// ── IMAGE SLIDER (hero code block cycling) ─────────
function initImageSlider() {
  const snippets = [
    `<span class="kw">const</span> <span class="fn">developer</span> = {
  name<span class="op">:</span> <span class="str">"Mustafa Adam"</span>,
  role<span class="op">:</span> <span class="str">"Software Engineer"</span>,
  stack<span class="op">:</span> [<span class="str">"HTML"</span>, <span class="str">"CSS"</span>, <span class="str">"JS"</span>,
         <span class="str">"PHP"</span>, <span class="str">"MySQL"</span>],
  available<span class="op">:</span> <span class="kw">true</span>,
  coffee<span class="op">:</span> <span class="str">"always"</span> ☕
};`,
    `<span class="kw">function</span> <span class="fn">buildSomethingCool</span>() {
  <span class="kw">const</span> idea <span class="op">=</span> <span class="fn">brainstorm</span>();
  <span class="kw">const</span> code <span class="op">=</span> <span class="fn">write</span>(idea);
  <span class="kw">const</span> result<span class="op">=</span> <span class="fn">deploy</span>(code);
  <span class="kw">return</span> result<span class="op">;</span> <span class="op">// 🚀</span>
}`,
    `<span class="kw">SELECT</span> *
<span class="kw">FROM</span>   projects
<span class="kw">WHERE</span>  quality <span class="op">=</span> <span class="str">'high'</span>
<span class="kw">AND</span>    passion <span class="op">=</span> <span class="kw">true</span>
<span class="kw">ORDER BY</span> impact <span class="kw">DESC</span>;`,
  ];

  const codeBody = document.querySelector('.code-body');
  if (!codeBody) return;
  let idx = 0;

  setInterval(() => {
    codeBody.style.opacity = '0';
    setTimeout(() => {
      idx = (idx + 1) % snippets.length;
      codeBody.innerHTML = snippets[idx];
      codeBody.style.opacity = '1';
    }, 300);
  }, 4000);

  codeBody.style.transition = 'opacity 0.3s ease';
}

// ── FOOTER YEAR ────────────────────────────────────
function setFooterYear() {
  const el = document.getElementById('footerYear');
  if (el) el.textContent = new Date().getFullYear();
}

// ── COOKIE HELPERS ─────────────────────────────────
function setCookie(name, value, days) {
  const d = new Date();
  d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
}

function getCookie(name) {
  const cookies = document.cookie.split(';').map(c => c.trim());
  for (const c of cookies) {
    if (c.startsWith(name + '=')) return c.substring(name.length + 1);
  }
  return '';
}

// ── SECURITY HELPER ────────────────────────────────
function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}
