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
            <h3 style="color: #2e1e53; margin-bottom: 1.5rem; text-align: center;">ভাইরাল হোন নিজের স্টাইলে। 🚀</h3>
    <!-- Promote Form Section (Visible by default) -->
    <div id="promote-section" style="display: block; max-width: 800px; margin: 0 auto; padding-top: 0rem;">
        <div class="form-card" style="border-top: 5px solid var(--primary-color);">
            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; text-align: center;">🚀 Promote Your Video</h3>
            <form id="promoteForm" action="process_promote.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="coin_title">
                        Video Link
                    </label>

                    <input type="text" id="coin_title" name="coin_title"
                        placeholder="Enter Your TikTok Video Link..."
                        required>
                
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
                    <div class="stepper-group">
                        <input type="number" id="price" name="price" value="100" min="100" readonly required>
                        <button type="button" id="minus-btn" class="stepper-btn">−</button>
                        <button type="button" id="plus-btn" class="stepper-btn">+</button>
                    </div>
                    <div id="estimated-result" style="margin-top: 0.5rem; font-weight: bold; color: #334897;">Estimated: 2,500 Views & 500 Likes</div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="+8801XXX-XXXXXX" required>
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
                    <textarea id="promote_trxid" name="description" rows="1" placeholder="Enter TrxID Here" required></textarea>
                </div>
 
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">🚀 Submit Boost Order</button>
            </form>
        </div>
    </div>

    <!-- GetCoin Section -->
    <div id="getcoin-section" style="display: none; max-width: 800px; margin: 0 auto;">
        <div class="form-card" style="border-top: 5px solid var(--primary-color);">
            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; text-align: center;">💎 Request For Coin</h3>
           <form id="getcoinForm" action="process_getcoin.php" method="POST">
                <div class="form-group">
                    <label for="coin_amount">Coin Amount</label>
                    <input type="number" id="coin_amount" name="coin_amount" placeholder="Enter coins amount" min="50" required>
                    <div id="coin-price-display" style="margin-top: 0.5rem; font-weight: bold; color: var(--primary-color);">Total Price: 0 ৳</div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="+8801XXX-XXXXXX" required>
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
                    <textarea id="getcoin_trxid" name="description" rows="3" placeholder="Enter TrxID Here" required></textarea>
                </div>
 

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Send Coin Order</button>
            </form>
        </div>
    </div>
    
    <!-- Business Section -->
    <div id="business-section" style="display: none; max-width: 800px; margin: 0 auto;">
        <div class="form-card" style="border-top: 5px solid var(--secondary-color);">
            <h3 style="color: var(--secondary-color); margin-bottom: 1.5rem; text-align: center;">🏢 Business Service Application</h3>
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
                    <label for="biz_type">Service Type</label>
                    <select id="biz_type" name="biz_type">
                        <option value="dealer">Digital Marketing </option>
                        <option value="collector">App or Website Development</option>
                        <option value="auction">Social Media Management</option>
                        <option value="jewelry">Video Production</option>
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
                    <label for="message">Why do you want to Discuss with us?</label>
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
                    <div class="faq-question">প্রশ্ন: (Promote) অপশন কাদের জন্য? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">উত্তর: যারা ভিডিও বুস্ট করার বিষয়ে কিছুই জানেন না (Promote) অপশন তাদের জন্য। আপনি পেমেন্ট করার পর আপনার ভিডিও লিংক ও পেমেন্ট ইনফো সাবমিট করবেন এরপর বাকি সমস্ত কাজ আমরা সততা, দক্ষতা এবং আন্তরিকতার সাথে সম্পন্ন করব।</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">প্রশ্ন: (GetCoin) অপশন কাদের জন্য? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">যারা নিজের ভিডিও নিজেই বুস্ট করতে পারেন বা শুধুমাত্র কয়েন নিতে চান তাদের জন্য GETCOIN অপসন। </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">প্রশ্ন: (Business) অপশন কাদের জন্য? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">যারা অনলাইনে বিসনেস করতে চান তারা চাইলে (Business) অপসন থেকে প্রোডাক্ট সেল, কনসালটেন্সি, অনলাইন বিসনেস মেনেজমেন্ট ইত্যাদি সার্ভিসেস নিতে পারেন। </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">প্রশ্ন: আমাদের থেকে কেন সার্ভিস নিবেন? <span class="faq-icon">+</span></div>
                    <div class="faq-answer">আমরা সততা, দক্ষতা এবং আন্তরিকতার সাথে গ্রাহকের দেয়া কাজ সঠিক সময়ে সম্পন্ন করে থাকি। তাই ১০০% নিশ্চিন্তে ও নিরাপদে আপনি আমাদের থেকে সার্ভিস নিতে পারেন। </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section End -->


<!-- Reviews Section -->
<section class="reviews-section">
    <div class="container">
        <div class="reviews-content">
            <h3 class="section-title">Collector Testimonials</h3>
            <div class="reviews-grid">
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>আলহামদুলিল্লাহ, <br>
তাদের সার্ভিস অনেক ভালো। আমি তাদের থেকে একাধিক বার সার্ভিস নিয়েছি।  <br>Highly recommended.</p>
                    <div class="reviewer">
                        <strong>Tanvir Ahmed</strong>
                        <span>Promote Customer</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>ওনাদের সার্ভিস অনেক ভালো <br>৫ মিনিটের মধ্যে coin দিয়ে দেয়। আপনারা চাইলে ওনাদের থেকে কয়েন নিতে পারেন। <br>সার্ভিস ভালো পাবেন আশাকরি। </p>
                    <div class="reviewer">
                        <strong>Rahat Kabir</strong>
                        <span>Coin Collector</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars">★★★★☆</div>
                    <p>"অনেক ভালো business রিলিটেড সাপোর্ট দিয়ে থাকে। <br>খুঁটিনাটি ও সিক্রেট বিষয়ে সহজ ভাবে আলোচনা করে. Android App  থেকে শুরু করে ওয়েব ডিজাইন, ডেভেলপমেন্ট ও ডিজিটাল মার্কেটিং বিষয়ে ওনাদের টিম পারদর্শী। <br>আমি ১০০% রিকোমেন্ড করি। </p>
                    <div class="reviewer">
                        <strong>Sultana Kamal</strong>
                        <span>Consultancy holder</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
