document.addEventListener('DOMContentLoaded', function () {
    initAlerts();
    initDeleteConfirm();
    initFormValidation();
    initLiveSearch();
    initPhoneFormat();
    initActiveNav();
    initRentDueHighlight();
});

function initAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.6s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 600);
        }, 4000);
    });
}

function initDeleteConfirm() {
    // Inject modal HTML once
    const modal = document.createElement('div');
    modal.id = 'confirm-modal';
    modal.innerHTML = `
        <div class="modal-overlay" id="modal-overlay">
            <div class="modal-box">
                <p class="modal-msg" id="modal-msg">Are you sure you want to delete this?</p>
                <div class="modal-actions">
                    <button class="btn-cancel" id="modal-cancel">Cancel</button>
                    <button class="btn-confirm-delete" id="modal-confirm">Yes, Delete</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    let pendingHref = null;

    // Intercept all delete links
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a[data-confirm]');
        if (!link) return;
        e.preventDefault();
        pendingHref = link.href;
        const msg = link.dataset.confirm || 'Are you sure you want to delete this?';
        document.getElementById('modal-msg').textContent = msg;
        document.getElementById('modal-overlay').classList.add('active');
    });

    document.getElementById('modal-cancel').addEventListener('click', function () {
        document.getElementById('modal-overlay').classList.remove('active');
        pendingHref = null;
    });

    document.getElementById('modal-confirm').addEventListener('click', function () {
        if (pendingHref) window.location.href = pendingHref;
    });

    // Close on backdrop click
    document.getElementById('modal-overlay').addEventListener('click', function (e) {
        if (e.target === this) {
            this.classList.remove('active');
            pendingHref = null;
        }
    });
}

function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            let valid = true;

            // Clear previous errors
            form.querySelectorAll('.field-error').forEach(el => el.remove());
            form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

            const fields = form.querySelectorAll('input[required], select[required]');
            fields.forEach(function (field) {
                const value = field.value.trim();

                if (value === '') {
                    showFieldError(field, 'This field is required.');
                    valid = false;
                    return;
                }

                // Phone validation
                if (field.name === 'phone') {
                    if (!/^[0-9+\-\s()]{7,15}$/.test(value)) {
                        showFieldError(field, 'Enter a valid phone number.');
                        valid = false;
                    }
                }

                // Email validation
                if (field.type === 'email') {
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        showFieldError(field, 'Enter a valid email address.');
                        valid = false;
                    }
                }

                // Password length
                if (field.type === 'password' && value.length < 6) {
                    showFieldError(field, 'Password must be at least 6 characters.');
                    valid = false;
                }

                // Positive number
                if (field.type === 'number' && parseFloat(value) <= 0) {
                    showFieldError(field, 'Enter a positive number.');
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector('.input-error');
                if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                // Show loading state on submit button
                const btn = form.querySelector('button[type="submit"], button:not([type])');
                if (btn) {
                    btn.disabled = true;
                    btn.dataset.original = btn.textContent;
                    btn.textContent = 'Please wait...';
                }
            }
        });
    });
}

function showFieldError(field, message) {
    field.classList.add('input-error');
    const err = document.createElement('span');
    err.className = 'field-error';
    err.textContent = message;
    field.parentNode.insertBefore(err, field.nextSibling);
}

function initLiveSearch() {
    const searchInput = document.getElementById('live-search');
    if (!searchInput) return;

    const tableId = searchInput.dataset.table || 'searchable-table';
    const table = document.getElementById(tableId);
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            const match = text.includes(query);
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        // Show "no results" row
        let noResults = table.querySelector('.no-results-row');
        if (visibleCount === 0) {
            if (!noResults) {
                const cols = table.querySelector('thead tr') ? table.querySelector('thead tr').children.length : 4;
                noResults = document.createElement('tr');
                noResults.className = 'no-results-row';
                noResults.innerHTML = `<td colspan="${cols}" style="text-align:center;padding:16px;color:#888;">No results found.</td>`;
                table.querySelector('tbody').appendChild(noResults);
            }
            noResults.style.display = '';
        } else if (noResults) {
            noResults.style.display = 'none';
        }
    });
}

function initPhoneFormat() {
    const phoneInputs = document.querySelectorAll('input[name="phone"]');
    phoneInputs.forEach(function (input) {
        input.addEventListener('input', function () {
            // Strip non-numeric (allow leading +)
            let val = this.value.replace(/[^\d+]/g, '');
            this.value = val;
        });
    });
}

function initActiveNav() {
    const navLinks = document.querySelectorAll('.nav-links a');
    const current = window.location.pathname;

    navLinks.forEach(function (link) {
        if (link.getAttribute('href') === current) {
            link.classList.add('nav-active');
        }
    });
}

function initRentDueHighlight() {
    const duecells = document.querySelectorAll('td.due-amount');
    duecells.forEach(function (cell) {
        const due = parseFloat(cell.textContent);
        const row = cell.closest('tr');
        if (due > 0) {
            row.classList.add('row-overdue');
        } else {
            row.classList.add('row-paid');
        }
    });
}

function showToast(message, type) {
    type = type || 'success';
    const toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(function () { toast.classList.add('toast-visible'); }, 10);
    setTimeout(function () {
        toast.classList.remove('toast-visible');
        setTimeout(function () { toast.remove(); }, 400);
    }, 3500);
}
