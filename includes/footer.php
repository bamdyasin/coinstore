    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>CoinStoreBD</h3>
                <p>ভাইরাল হোন নিজের স্টাইলে। 🚀 <br>
আমরা সততা, দক্ষতা এবং আন্তরিকতার একমাত্র প্রতীক আমাদের এই কয়েন স্টোর।  সঠিক সময়ে  ১০০% নিশ্চিন্তে ও নিরাপদে সার্ভিস নিন। 🚀</p>
            </div>
            

            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="footer-social-row">
                    <!-- Contact Icons -->
                    <a href="https://maps.google.com" target="_blank" class="contact-item" title="Our Location">
                        <span class="contact-icon"><i class="fas fa-location-dot"></i></span>
                    </a>
                    <a href="https://www.tiktok.com/@coinstorebd" target="_blank" class="contact-item" title="TikTok">
                        <span class="contact-icon"><i class="fab fa-tiktok"></i></span>
                    </a>
                    <a href="https://www.facebook.com/coinstorebd" target="_blank" class="contact-item" title="Facebook">
                        <span class="contact-icon"><i class="fab fa-facebook-f"></i></span>
                    </a>
                    <a href="https://wa.me/8801845464034" target="_blank" class="contact-item" title="WhatsApp">
                        <span class="contact-icon"><i class="fab fa-whatsapp"></i></span>
                    </a>
                    <a href="https://www.youtube.com/@coinstorebd" target="_blank" class="contact-item" title="YouTube">
                        <span class="contact-icon"><i class="fab fa-youtube"></i></span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>All rights reserved.</p>
        </div>
    </footer>
    <!-- Order Status Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="statusResult">
                <!-- Result will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <!-- Success Notification Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content" style="text-align: center; padding: 3rem 2rem;">
            <div style="margin-bottom: 1.5rem;">
                <div style="width: 80px; height: 80px; background: #e8f5e9; color: #2ecc71; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto; border: 4px solid #2ecc71; animation: scaleUp 0.5s ease-out;">
                    ✓
                </div>
            </div>
            <h2 id="successTitle" style="color: var(--secondary-color); margin-bottom: 1rem; font-family: 'Playfair Display', serif;">Success!</h2>
            <p id="successMessage" style="color: #666; margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.5;"></p>
            <button onclick="closeSuccessModal()" class="btn btn-primary" style="width: 100%;">Continue</button>
        </div>
    </div>

    <style>
    @keyframes scaleUp {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    </style>

    <script src="assets/js/main.js"></script>
</body>
</html>
