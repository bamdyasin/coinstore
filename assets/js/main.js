// Main JavaScript for CoinStoreBD

// Success Modal Functions
window.showSuccessModal = (message, title = 'Success!') => {
    const modal = document.getElementById('successModal');
    const msgEl = document.getElementById('successMessage');
    const titleEl = document.getElementById('successTitle');
    
    if (modal && msgEl && titleEl) {
        titleEl.textContent = title;
        msgEl.textContent = message;
        modal.style.display = 'block';
    }
};

window.showErrorModal = (message, title = 'Validation Error') => {
    const statusResult = document.getElementById('statusResult');
    const statusModal = document.getElementById('statusModal');
    if (statusResult && statusModal) {
        statusResult.innerHTML = `
            <div class="status-error" style="text-align: center; padding: 1rem;">
                <div style="width: 60px; height: 60px; background: #ffebee; color: #e74c3c; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; border: 3px solid #e74c3c; animation: shake 0.5s ease-in-out;">
                    ✕
                </div>
                <h3 style="color: var(--secondary-color); margin-bottom: 0.5rem; font-family: 'Playfair Display', serif;">${title}</h3>
                <p style="color: #666; line-height: 1.5;">${message}</p>
                <button onclick="document.getElementById('statusModal').style.display='none'" class="btn" style="margin-top: 1.5rem; width: 100%; background: #e74c3c; color: white; border: none; border-radius: 8px; padding: 0.8rem;">Try Again</button>
            </div>`;
        statusModal.style.display = 'block';
    } else {
        alert(message);
    }
};

window.closeSuccessModal = () => {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'none';
        // Clean up URL
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('message');
        url.searchParams.delete('title');
        window.history.replaceState({}, document.title, url.pathname);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Check for success message in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        const msg = urlParams.get('message') || 'Action completed successfully!';
        const title = urlParams.get('title') || 'Success!';
        showSuccessModal(msg, title);
    }
    
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

    // Auto-switch tab based on URL parameter
    const activeTabParam = urlParams.get('tab');
    if (activeTabParam && sections[activeTabParam]) {
        const targetTabItem = document.querySelector(`.tab-item[data-tab="${activeTabParam}"]`);
        if (targetTabItem) targetTabItem.click();
    }

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
    const plusBtn = document.getElementById('plus-btn');
    const minusBtn = document.getElementById('minus-btn');

    if (priceInput && categorySelect && estimatedResult) {
        const updateEstimate = () => {
            const budget = parseFloat(priceInput.value) || 0;
            const type = categorySelect.value;
            let displayValue = '';

            if (type === 'VideoViews') {
                const views = Math.floor(budget * 25);
                const likes = Math.floor(budget * 5);
                displayValue = `Estimated: ${views.toLocaleString()} Views & ${likes.toLocaleString()} Likes`;
            } else if (type === 'LikeComments') {
                const views = Math.floor(budget * 20);
                const likes = Math.floor(budget * 6);
                displayValue = `Estimated: ${views.toLocaleString()} Views & ${likes.toLocaleString()} Likes & Comments`;
            } else if (type === 'Followers') {
                const followers = Math.floor(budget * 2);
                const views = Math.floor(budget * 20);
                displayValue = `Estimated: ${views.toLocaleString()} Views & ${followers.toLocaleString()} Followers`;
            }

            estimatedResult.textContent = displayValue;
        };

        if (plusBtn && minusBtn) {
            plusBtn.addEventListener('click', () => {
                let current = parseInt(priceInput.value);
                if (current === 100) {
                    priceInput.value = 200;
                } else {
                    priceInput.value = current + 200;
                }
                updateEstimate();
            });

            minusBtn.addEventListener('click', () => {
                let current = parseInt(priceInput.value);
                if (current > 100) {
                    if (current === 200) {
                        priceInput.value = 100;
                    } else {
                        priceInput.value = current - 200;
                    }
                    updateEstimate();
                }
            });
        }

        categorySelect.addEventListener('change', updateEstimate);
    }

    // Payment Option Logic
    const paymentSelect = document.getElementById('payment_option');
    const agentDisplay = document.getElementById('agent-number-display');
    const agentNumber = document.getElementById('agent-number');
    const paymentMethodName = document.getElementById('payment-method-name');

    if (paymentSelect && agentDisplay && agentNumber && paymentMethodName) {
        const agentNumbers = {
            'Bkash': '01845464034',
            'Nagad': '01845464034',
            'Rocket': '01845464034'
        };

        paymentSelect.addEventListener('change', () => {
            const selected = paymentSelect.value;
            if (selected && agentNumbers[selected]) {
                paymentMethodName.textContent = selected;
                agentNumber.textContent = agentNumbers[selected];
                agentDisplay.style.display = 'block';
            } else {
                agentDisplay.style.display = 'none';
            }
        });
    }

    // Payment Option Logic (GetCoin Form)
    const getcoinPaymentSelect = document.getElementById('getcoin_payment_option');
    const getcoinAgentDisplay = document.getElementById('getcoin-agent-number-display');
    const getcoinAgentNumber = document.getElementById('getcoin-agent-number');
    const getcoinPaymentMethodName = document.getElementById('getcoin-payment-method-name');

    if (getcoinPaymentSelect && getcoinAgentDisplay && getcoinAgentNumber && getcoinPaymentMethodName) {
        const agentNumbers = {
            'Bkash': '01845464034',
            'Nagad': '01845464034',
            'Rocket': '01845464034'
        };

        getcoinPaymentSelect.addEventListener('change', () => {
            const selected = getcoinPaymentSelect.value;
            if (selected && agentNumbers[selected]) {
                getcoinPaymentMethodName.textContent = selected;
                getcoinAgentNumber.textContent = agentNumbers[selected];
                getcoinAgentDisplay.style.display = 'block';
            } else {
                getcoinAgentDisplay.style.display = 'none';
            }
        });
    }

    // Coin Price Calculation Logic (GetCoin Form)
    const coinAmountInput = document.getElementById('coin_amount');
    const coinPriceDisplay = document.getElementById('coin-price-display');

    if (coinAmountInput && coinPriceDisplay) {
        coinAmountInput.addEventListener('input', () => {
            const amount = parseFloat(coinAmountInput.value) || 0;
            const rate = 2;
            const totalPrice = amount * rate;
            coinPriceDisplay.textContent = `Total Price: ${totalPrice.toLocaleString()} Taka`;
        });
    }

    // Order Status Search Logic
    const searchForm = document.getElementById('searchStatusForm');
    const searchInput = document.getElementById('searchTrxID');
    const statusModal = document.getElementById('statusModal');
    const statusResult = document.getElementById('statusResult');
    const closeModal = document.querySelector('.close-modal');

    if (searchForm && searchInput && statusModal && statusResult) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const trxid = searchInput.value.trim();

            if (!trxid) {
                alert('Please enter a Transaction ID');
                return;
            }

            // Show loading or just fetch
            statusResult.innerHTML = '<div style="text-align:center; padding:2rem;">Searching...</div>';
            statusModal.style.display = 'block';

            fetch(`search_status.php?trxid=${encodeURIComponent(trxid)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusResult.innerHTML = data.html;

                        // Logic for Timer and WhatsApp Button
                        if (data.status === 'pending' || data.status === 'rejected') {
                            const createdAt = new Date(data.created_at).getTime();
                            const now = new Date().getTime();
                            const diffMinutes = Math.floor((now - createdAt) / 1000 / 60);

                            if (data.status === 'pending' && diffMinutes < 10) {
                                // Show Timer
                                const remainingMs = (10 * 60 * 1000) - (now - createdAt);
                                const timerContainer = document.createElement('div');
                                timerContainer.style.textAlign = 'center';
                                timerContainer.style.marginTop = '1rem';
                                timerContainer.style.padding = '10px';
                                timerContainer.style.background = '#fff8e1';
                                timerContainer.style.borderRadius = '8px';
                                timerContainer.style.border = '1px solid #ffe082';
                                
                                let timeLeft = Math.floor(remainingMs / 1000);
                                
                                const updateTimerDisplay = () => {
                                    const mins = Math.floor(timeLeft / 60);
                                    const secs = timeLeft % 60;
                                    timerContainer.innerHTML = `
                                        <div style="font-size: 0.85rem; color: #f39c12; font-weight: bold; margin-bottom: 5px;">অর্ডার প্রসেসিং হচ্ছে...</div>
                                        <div style="font-size: 1.2rem; font-weight: bold; color: #d35400;">${mins}:${secs < 10 ? '0' : ''}${secs} অপেক্ষা করুন।</div>
                                    `;
                                };
                                
                                updateTimerDisplay();
                                statusResult.appendChild(timerContainer);
                                
                                const timerInterval = setInterval(() => {
                                    timeLeft--;
                                    if (timeLeft <= 0) {
                                        clearInterval(timerInterval);
                                        // Once timer ends, we could add the WhatsApp button
                                        location.reload(); // Simple refresh to update status
                                    } else {
                                        updateTimerDisplay();
                                    }
                                }, 1000);

                                // Clear interval when modal closes
                                const closeBtn = document.querySelector('.close-modal');
                                closeBtn.addEventListener('click', () => clearInterval(timerInterval));
                                window.addEventListener('click', (e) => {
                                    if (e.target === statusModal) clearInterval(timerInterval);
                                });

                            } else if (data.status === 'rejected' || (data.status === 'pending' && diffMinutes >= 10)) {
                                // Show WhatsApp Support Button
                                const whatsappBtn = document.createElement('a'); 
                                whatsappBtn.href = "https://wa.me/8801845464034?text=" + encodeURIComponent("হাই, আমার অর্ডার " + data.status + " কেন? TrxID: " + trxid + " দয়া করে দেখন!");
                                whatsappBtn.target = "_blank";
                                whatsappBtn.className = "btn";
                                whatsappBtn.style.width = "100%";
                                whatsappBtn.style.marginTop = "1rem";
                                whatsappBtn.style.background = "#25D366";
                                whatsappBtn.style.color = "white";
                                whatsappBtn.style.border = "none";
                                whatsappBtn.innerHTML = "Support (WhatsApp)";
                                statusResult.appendChild(whatsappBtn);
                            }
                        }
                    } else {
                        statusResult.innerHTML = `<div class="status-error">
                            <h3>Not Found</h3>
                            <p>${data.message}</p>
                        </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusResult.innerHTML = '<div class="status-error"><p>An error occurred. Please try again.</p></div>';
                });
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            statusModal.style.display = 'none';
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === statusModal) {
            statusModal.style.display = 'none';
        }
    });

    // Form Submission Duplicate & Validation Check
    const promoteForm = document.getElementById('promoteForm');
    const getcoinForm = document.getElementById('getcoinForm');

    const validateForm = (formId) => {
        const form = document.getElementById(formId);
        if (!form) return true;

        let isValid = true;
        let errorMessage = "";

        // 1. WhatsApp Validation (11 digits)
        const whatsappInput = form.querySelector('input[name="whatsapp"]');
        if (whatsappInput) {
            const val = whatsappInput.value.trim();
            if (val.length < 11 || !/^\+?\d+$/.test(val)) {
                isValid = false;
                errorMessage = "WhatsApp number must be at least 11 digits.";
            }
        }

        // 2. TrxID Validation (10-15 chars)
        const trxInput = form.querySelector('textarea[name="description"]');
        if (trxInput) {
            const val = trxInput.value.trim();
            if (val.length < 10 || val.length > 15) {
                isValid = false;
                errorMessage = "Transaction ID must be between 10 to 15 characters.";
            }
        }

        // 3. Link Validation (for Promote form)
        if (formId === 'promoteForm') {
            const linkInput = document.getElementById('coin_title');
            if (linkInput) {
                const val = linkInput.value.trim();
                // Improved regex to support TikTok desktop, mobile, and URLs with parameters
                const urlRegex = /^(https?:\/\/)?(www\.|vm\.|vt\.|t\.)?tiktok\.com\/.*$/i;
                if (!urlRegex.test(val)) {
                    isValid = false;
                    errorMessage = "Please enter a valid TikTok video link.";
                }
            }
        }

        if (!isValid) {
            showErrorModal(errorMessage);
        }
        return isValid;
    };

    const checkAndSubmit = (form, trxInputId) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // First run our new validations
            if (!validateForm(form.id)) return;

            const trxid = document.getElementById(trxInputId).value.trim();

            fetch(`check_duplicate_trxid.php?trxid=${encodeURIComponent(trxid)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.duplicate) {
                        showErrorModal("This Transaction ID has already been used. Please provide a unique TrxID.", "Duplicate TrxID");
                    } else {
                        // Unique, proceed with normal submission
                        form.submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    form.submit(); // Fallback to normal submit on error
                });
        });
    };

    if (promoteForm) checkAndSubmit(promoteForm, 'promote_trxid');
    if (getcoinForm) checkAndSubmit(getcoinForm, 'getcoin_trxid');
});
