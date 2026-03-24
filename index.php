<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<main class="container" id="main-content">
    <!-- Default Welcome Message (Hidden by default now) -->
    <div id="welcome-message" style="text-align: center; padding: 5rem 0; color: #888; display: none;">
        <h2>Welcome to CoinStoreBD</h2>
        <p>Select a tab above to get started.</p>
    </div>

    <!-- Promote Form Section (Visible by default) -->
    <div id="promote-section" style="display: block; max-width: 800px; margin: 0 auto; padding-top: 0rem;">
        <div class="form-card" style="border-top: 5px solid var(--primary-color);">
            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; text-align: center;">🚀 Promote Your Video</h3>
            <form id="promoteForm" action="process_promote.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="coin_title">Video Link</label>
                    <input type="text" id="coin_title" name="coin_title" placeholder="Enter Your Video Link..." required>
                </div>

                <div class="form-group">
                    <label for="category">Promote Type</label>
                    <select id="category" name="category">
                        <option value="VideoViews">More Video Views</option>
                        <option value="LikeComments">Like & Comments</option>
                        <option value="Followers">More Followers</option> 
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Your Budget (৳)</label>
                    <input type="number" id="price" name="price" placeholder="TK. 100" min="100" required>
                    <div id="estimated-result" style="margin-top: 0.5rem; font-weight: bold; color: var(--primary-color);">Estimated: 0 Views</div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Contact Number</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="01XXX-XXXXXX" required>
                </div>

                <div class="form-group">
                    <label for="payment_option">Payment Option</label>
                    <select id="payment_option" name="payment_option" required>
                        <option value="">Select Payment Option</option>
                        <option value="Bkash">Bkash Number</option>
                        <option value="Nagad">Nagad Number</option>
                        <option value="Rocket">Rocket Number</option>
                    </select>
                    <div id="agent-number-display" style="margin-top: 0.5rem; font-weight: bold; color: var(--secondary-color); display: none;">
                        <span id="payment-method-name"></span> Agent: <span id="agent-number"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="promote_trxid">Transaction ID</label>
                    <textarea id="promote_trxid" name="description" rows="1" placeholder="Input transaction ID or full message" required></textarea>
                </div>
 
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">🚀 Submit for Review</button>
            </form>
        </div>
    </div>

    <!-- GetCoin Section -->
    <div id="getcoin-section" style="display: none; max-width: 800px; margin: 0 auto;">
        <div class="form-card" style="border-top: 5px solid var(--primary-color);">
            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; text-align: center;">💎 Request For Coin</h3>
            <p style="text-align: center; font-size: 0.9rem; margin-bottom: 1.5rem; color: #666;">Looking for something specific? Let our experts find it for you.</p>
            <form id="getcoinForm" action="process_getcoin.php" method="POST">
                <div class="form-group">
                    <label for="coin_amount">Coin Amount</label>
                    <input type="number" id="coin_amount" name="coin_amount" placeholder="Enter amount of coins" min="50" required>
                    <div id="coin-price-display" style="margin-top: 0.5rem; font-weight: bold; color: var(--primary-color);">Total Price: 0 ৳</div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Contact Number</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="01XXX-XXXXXX" required>
                </div>
                
                <div class="form-group">
                    <label for="getcoin_payment_option">Payment Option</label>
                    <select id="getcoin_payment_option" name="payment_option" required>
                        <option value="">Select Payment Option</option>
                        <option value="Bkash">Bkash Number</option>
                        <option value="Nagad">Nagad Number</option>
                        <option value="Rocket">Rocket Number</option>
                    </select>
                    <div id="getcoin-agent-number-display" style="margin-top: 0.5rem; font-weight: bold; color: var(--secondary-color); display: none;">
                        <span id="getcoin-payment-method-name"></span> Agent: <span id="getcoin-agent-number"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="getcoin_trxid">Transaction ID</label>
                    <textarea id="getcoin_trxid" name="description" rows="3" placeholder="Input transaction ID or full message" required></textarea>
                </div>
 

                <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Send Request</button>
            </form>
        </div>
    </div>
    
    <!-- Business Section -->
    <div id="business-section" style="display: none; max-width: 800px; margin: 0 auto;">
        <div class="form-card" style="border-top: 5px solid var(--secondary-color);">
            <h3 style="color: var(--secondary-color); margin-bottom: 1.5rem; text-align: center;">🏢 Business Partnership Application</h3>
            <form action="process_business.php" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="biz_name">Business Name</label>
                        <input type="text" id="biz_name" name="biz_name" placeholder="Company Ltd." required>
                    </div>
                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person" placeholder="Full Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="biz_type">Business Type</label>
                    <select id="biz_type" name="biz_type">
                        <option value="dealer">Professional Dealer</option>
                        <option value="collector">Private Collector / Investor</option>
                        <option value="auction">Auction House</option>
                        <option value="jewelry">Jewelry Shop</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="experience">Years of Experience</label>
                    <input type="number" id="experience" name="experience" placeholder="e.g. 5" required>
                </div>

                <div class="form-group">
                    <label for="website">Website / Social Media (Optional)</label>
                    <input type="url" id="website" name="website" placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label for="message">Why do you want to partner with us?</label>
                    <textarea id="message" name="message" rows="3" placeholder="Tell us about your business goals..."></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%; background: var(--secondary-color); color: white;">Apply Now</button>
            </form>
        </div>
    </div>
</main>

<!-- Q&A (FAQ) Section -->
<section class="faq-section">
    <div class="container">
        <div class="faq-content">
            <h2 class="section-title">Customer Questions</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">How do I know the coins are authentic? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">Every coin promoted on our platform undergoes a rigorous multi-step verification process by our in-house experts and third-party grading services.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What is the "Promote" feature? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">The Promote feature allows collectors to showcase their rare items on the homepage or at the top of search results to reach thousands of potential buyers.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Is shipping secure across Bangladesh? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">Yes, we use insured, high-security logistics partners to ensure your valuable coins reach you discreetly and safely anywhere in Bangladesh.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How can I become a business partner? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">Simply fill out the form in the "Business" tab. Our team will review your application and contact you within 48 hours for onboarding.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Motive Section -->
<section class="motive-section">
    <div class="container">
        <div class="motive-content">
            <span class="motive-badge">Our Mission</span>
            <h2>Preserving History, One Coin at a Time</h2>
            <p>At CoinStoreBD, our motive is to bridge the gap between passionate collectors and authentic numismatic treasures. We believe that every coin tells a story of an era, a civilization, or a milestone. Our goal is to provide a secure, transparent, and professional platform where history isn't just sold, but celebrated.</p>
            <div class="motive-stats">
                <div class="stat-item">
                    <h4>10k+</h4>
                    <p>Authentic Coins</p>
                </div>
                <div class="stat-item">
                    <h4>5k+</h4>
                    <p>Happy Collectors</p>
                </div>
                <div class="stat-item">
                    <h4>100%</h4>
                    <p>Secure Escrow</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="reviews-section">
    <div class="container">
        <div class="reviews-content">
            <h3 class="section-title">Collector Testimonials</h3>
            <div class="reviews-grid">
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>"Found a rare 1921 Silver Dollar in pristine condition. The authentication process gave me complete peace of mind. Best in BD!"</p>
                    <div class="reviewer">
                        <strong>Ahmed Tanvir</strong>
                        <span>Verified Collector</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>"The business partnership has been a game-changer for my local shop. Their inventory management tools are top-notch."</p>
                    <div class="reviewer">
                        <strong>Rahat Kabir</strong>
                        <span>Dealer Partner</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★☆</div>
                    <p>"Great customer support. They helped me find a specific ancient Roman coin I've been looking for for years."</p>
                    <div class="reviewer">
                        <strong>Sultana Kamal</strong>
                        <span>Hobbyist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
