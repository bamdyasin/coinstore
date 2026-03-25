    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>CoinStoreBD</h3>
                <p><?php echo $s['footer_about'] ?? 'Your trusted source for authentic rare and collectible coins in Bangladesh.'; ?></p>
            </div>
            

            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="footer-social-row">
                    <!-- Contact Icons -->
                    <div class="contact-item" title="Our Location">
                        <span class="contact-icon">📍</span>
                    </div>
                    <div class="contact-item" title="Call Us">
                        <span class="contact-icon">📞</span>
                    </div>
                    <div class="contact-item" title="Email Us">
                        <span class="contact-icon">📧</span>
                    </div>
                    <div class="contact-item" title="Call Us">
                        <span class="contact-icon">📞</span>
                    </div>
                    <div class="contact-item" title="Email Us">
                        <span class="contact-icon">📧</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p><?php echo $s['footer_copyright'] ?? '&copy; ' . date('Y') . ' CoinStoreBD. All rights reserved.'; ?></p>
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

    <script src="assets/js/main.js"></script>
</body>
</html>
