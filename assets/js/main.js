// Main JavaScript for CoinStoreBD
document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            mobileMenu.classList.toggle('is-active');
            
            const spans = mobileMenu.querySelectorAll('span');
            if (mobileMenu.classList.contains('is-active')) {
                spans[0].style.transform = 'rotate(-45deg) translate(-5px, 6px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(45deg) translate(-5px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }

    // Tab Switching Logic for Body Content
    const tabItems = document.querySelectorAll('.tab-item');
    const welcomeMessage = document.getElementById('welcome-message');
    
    // Content sections
    const sections = {
        'promote': document.getElementById('promote-section'),
        'getcoin': document.getElementById('getcoin-section'),
        'business': document.getElementById('business-section')
    };

    tabItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const targetTab = item.getAttribute('data-tab');

            // Deactivate all tabs
            tabItems.forEach(i => i.classList.remove('active'));
            // Activate clicked tab
            item.classList.add('active');

            // Hide welcome message
            if (welcomeMessage) welcomeMessage.style.display = 'none';

            // Hide all sections first
            Object.values(sections).forEach(section => {
                if (section) section.style.display = 'none';
            });

            // Show target section
            if (sections[targetTab]) {
                sections[targetTab].style.display = 'block';
            }

            // Smooth scroll to top when clicking tabs
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    // FAQ Accordion Logic
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(q => {
        q.addEventListener('click', () => {
            const item = q.parentElement;
            
            // Close other FAQ items if you want only one open at a time
            document.querySelectorAll('.faq-item').forEach(i => {
                if (i !== item) i.classList.remove('active');
            });

            item.classList.toggle('active');
        });
    });

    // Estimated Result Logic for Promote Form
    const priceInput = document.getElementById('price');
    const categorySelect = document.getElementById('category');
    const estimatedResult = document.getElementById('estimated-result');

    if (priceInput && categorySelect && estimatedResult) {
        const updateEstimate = () => {
            const budget = parseFloat(priceInput.value) || 0;
            const type = categorySelect.value;
            let estimate = 0;
            let unit = '';

            if (type === 'VideoViews') {
                estimate = Math.floor(budget * 15);
                unit = 'Views';
            } else if (type === 'LikeComments') {
                estimate = Math.floor(budget * 1.5);
                unit = 'Likes & Comments';
            } else if (type === 'Followers') {
                estimate = Math.floor(budget * 0.8);
                unit = 'Followers';
            }

            estimatedResult.textContent = `Estimated: ${estimate.toLocaleString()} ${unit}`;
        };

        priceInput.addEventListener('input', updateEstimate);
        categorySelect.addEventListener('change', updateEstimate);
    }
});
