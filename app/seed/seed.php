<?php
/**
 * Seeds the database with the content defined in the website rebuild brief.
 * Safe to run once on a fresh install.
 */
function seed_database(): void
{
    $now = now();

    // ---------- Services ----------
    $services = require __DIR__ . '/services.php';
    foreach ($services as $i => $s) {
        $faqs = array_map(fn($f) => ['q' => $f[0], 'a' => $f[1]], $s['faqs'] ?? []);
        DB::insert('services', [
            'slug' => $s['slug'],
            'title' => $s['title'],
            'menu_label' => $s['menu_label'] ?? '',
            'category' => $s['category'],
            'excerpt' => $s['excerpt'],
            'hero_text' => $s['hero_text'],
            'image' => '',
            'icon' => $s['icon'] ?? '',
            'what_is' => Html::paragraphs($s['what_is']),
            'conditions' => $s['conditions'],
            'how_it_works' => Html::paragraphs($s['how_it_works']),
            'benefits' => $s['benefits'],
            'what_to_expect' => Html::paragraphs($s['what_to_expect']),
            'faqs' => json_encode($faqs),
            'related' => $s['related'],
            'body_areas' => $s['body_areas'],
            'featured' => (int)($s['featured'] ?? 0),
            'coming_soon' => (int)($s['coming_soon'] ?? 0),
            'show_in_menu' => (int)($s['show_in_menu'] ?? 1),
            'needs_review' => 1,
            'sort_order' => ($i + 1) * 10,
            'status' => $s['status'] ?? 'published',
            'meta_title' => $s['title'] . ' in Gilbert & Tempe, AZ',
            'meta_description' => str_limit($s['excerpt'], 155),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    // ---------- Providers ----------
    $providers = [
        ['dr-andre-silano', 'Dr. Andre Silano', 'Clinic Director / Chiropractic Doctor', 'chiropractor', 'chiropractic-therapy,spinal-decompression-therapy,car-accident-injury-treatment,soft-tissue-management'],
        ['dr-christopher-boeke', 'Dr. Christopher Boeke', 'Physician Assistant', 'physician_assistant', 'trigger-point-and-joint-injections,ultrasound-guided-injections-and-diagnostics,regenerative-medicine,knee-pain-relief'],
        ['dr-darin-krueger', 'Dr. Darin Krueger', 'Chiropractor', 'chiropractor', 'chiropractic-therapy,spinal-decompression-therapy,soft-tissue-management,sports-injuries-and-physical-fitness'],
        ['dr-scott-griffin', 'Dr. Scott Griffin', 'Chiropractor', 'chiropractor', 'chiropractic-therapy,disc-injury-treatment,work-injury-compensation,soft-tissue-management'],
        ['dr-todd-dreitzler', 'Dr. Todd Dreitzler', 'Family Medicine Physician, M.D.', 'family_medicine', 'trigger-point-and-joint-injections,regenerative-medicine,allergy-testing,theramine'],
        ['michael-d-prisbrey', 'Michael D. Prisbrey', 'Physician Assistant', 'physician_assistant', 'trigger-point-and-joint-injections,ultrasound-guided-injections-and-diagnostics,shockwave-therapy,pens-dry-needling-treatment'],
    ];
    foreach ($providers as $i => [$slug, $name, $title, $type, $svc]) {
        $role = strtolower($title);
        DB::insert('providers', [
            'slug' => $slug,
            'name' => $name,
            'credentials' => '',
            'title' => $title,
            'type' => $type,
            'photo' => '',
            'photo_position' => '50% 20%',
            'locations' => '',
            'short_bio' => $name . ' is part of the integrated All Star Health care team, working alongside our medical providers, chiropractors and rehabilitation professionals.',
            'bio' => '<p>' . e($name) . ' serves patients at All Star Health Spine &amp; Joint Care as ' . (preg_match('/^[aeiou]/i', $role) ? 'an ' : 'a ') . e($role) . '. Our providers work together under one roof so each patient\'s care plan can draw on more than one discipline.</p>',
            'education' => '',
            'experience' => '',
            'philosophy' => '',
            'focus' => '',
            'services' => $svc,
            'needs_review' => 1,
            'sort_order' => ($i + 1) * 10,
            'status' => 'published',
            'meta_title' => $name . ' — ' . $title,
            'meta_description' => $name . ', ' . $title . ' at All Star Health Spine & Joint Care serving Gilbert and Tempe, Arizona.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    // ---------- Locations ----------
    DB::insert('locations', [
        'slug' => 'gilbert', 'name' => 'Gilbert', 'address' => '2730 South Val Vista Dr. #188', 'city' => 'Gilbert', 'state' => 'AZ', 'zip' => '85295',
        'phone' => '844-844-4755', 'fax' => '480-324-0589',
        'hours' => json_encode([['days' => 'Monday – Thursday', 'time' => '7:30 AM – 5:30 PM', 'schema' => ['Mo-Th 07:30-17:30']]]),
        'map_embed' => '', 'directions_url' => '', 'image' => '',
        'description' => 'Our Gilbert office on South Val Vista Drive serves patients from Gilbert, Mesa, Chandler and the surrounding East Valley.',
        'sort_order' => 10, 'status' => 'published', 'created_at' => $now, 'updated_at' => $now,
    ]);
    DB::insert('locations', [
        'slug' => 'tempe', 'name' => 'Tempe', 'address' => '6625 South Rural Road, #104', 'city' => 'Tempe', 'state' => 'AZ', 'zip' => '85283',
        'phone' => '844-844-4755', 'fax' => '480-833-5078',
        'hours' => json_encode([
            ['days' => 'Monday & Thursday', 'time' => '7:30 AM – 6:30 PM', 'schema' => ['Mo,Th 07:30-18:30']],
            ['days' => 'Tuesday & Wednesday', 'time' => '7:30 AM – 5:30 PM', 'schema' => ['Tu,We 07:30-17:30']],
            ['days' => 'Friday – Sunday', 'time' => 'Closed'],
        ]),
        'map_embed' => '', 'directions_url' => '', 'image' => '',
        'description' => 'Our Tempe office on South Rural Road serves patients from Tempe, Chandler, Mesa and the surrounding communities.',
        'sort_order' => 20, 'status' => 'published', 'created_at' => $now, 'updated_at' => $now,
    ]);

    // ---------- FAQs ----------
    $home = [
        ['Do you accept insurance?', 'We accept most major plans, including Medicare. Contact the practice to verify your specific benefits — our team offers a complimentary benefits check.'],
        ['Do you offer same-day appointments?', 'Yes. Same-day appointments and walk-ins are welcome when availability permits.'],
        ['Do you treat car accident injuries?', 'Yes. Dedicated automobile injury treatment is available at both of our offices.'],
        ['Do you treat work injuries?', 'Yes. Work injury treatment is available.'],
        ['Are treatments non-surgical?', 'Our practice emphasizes non-surgical orthopedic and pain treatment options.'],
        ['Where are your offices?', 'We have two offices in Arizona: Gilbert (2730 South Val Vista Dr. #188) and Tempe (6625 South Rural Road, #104).'],
        ['How do I know which treatment I need?', 'Start with an evaluation so our clinical team can determine appropriate care. You don\'t need to know medical terms — just tell us what hurts and what you\'d like to get back to.'],
    ];
    $billing = [
        ['What is a complimentary benefits check?', 'Before your visit, our insurance team can verify your coverage and explain the benefits that may apply to your care — at no cost to you.'],
        ['Do you accept Medicare?', 'Yes, we accept Medicare along with most major commercial insurance plans.'],
        ['What if my plan does not cover a treatment?', 'We will explain your options before treatment begins. Flexible payment options may be available.'],
        ['Do you treat auto accident and work injury claims?', 'Yes. Bring your claim information and our team will help with the details.'],
    ];
    foreach ($home as $i => [$q, $a]) {
        DB::insert('faqs', ['question' => $q, 'answer' => $a, 'grp' => 'home', 'sort_order' => ($i + 1) * 10, 'status' => 'published', 'created_at' => $now, 'updated_at' => $now]);
    }
    foreach ($billing as $i => [$q, $a]) {
        DB::insert('faqs', ['question' => $q, 'answer' => $a, 'grp' => 'billing', 'sort_order' => ($i + 1) * 10, 'status' => 'published', 'created_at' => $now, 'updated_at' => $now]);
    }

    // ---------- Testimonials (names from the current site; paste original wording in the dashboard) ----------
    foreach (['Amy H.', 'Katie H.', 'Bryt H.', 'Tamara S.', 'Claudia T.', 'M.I.', 'Kylie A.'] as $i => $n) {
        DB::insert('testimonials', [
            'name' => $n, 'label' => $n === 'M.I.' ? 'Verified Patient' : 'Patient', 'content' => '', 'rating' => 5, 'featured' => 1,
            'sort_order' => ($i + 1) * 10, 'status' => 'draft', 'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    // ---------- Pages ----------
    foreach (seed_pages() as $i => $p) {
        DB::insert('pages', array_merge([
            'eyebrow' => '', 'intro' => '', 'image' => '', 'content' => '', 'template' => 'default', 'show_cta' => 1, 'is_system' => 0,
            'needs_review' => 0, 'status' => 'published', 'meta_title' => '', 'meta_description' => '',
        ], $p, ['sort_order' => ($i + 1) * 10, 'created_at' => $now, 'updated_at' => $now]));
    }

    // ---------- Redirects for common legacy variations ----------
    foreach ([
        ['/service/', '/pain-treatments/'], ['/services/', '/pain-treatments/'], ['/doctor/', '/our-doctor/'],
        ['/our-doctors/', '/our-doctor/'], ['/providers/', '/our-doctor/'], ['/about/', '/about-us/'],
        ['/contact/', '/contact-us/'], ['/appointment/', '/make-appointment/'], ['/home/', '/'],
    ] as [$from, $to]) {
        DB::insert('redirects', ['source' => $from, 'target' => $to, 'code' => 301, 'hits' => 0, 'note' => 'Legacy URL', 'created_at' => $now, 'updated_at' => $now]);
    }
}

function seed_pages(): array
{
    return [
        [
            'slug' => 'about-us', 'title' => 'About All Star Health', 'eyebrow' => 'About Us', 'template' => 'about', 'is_system' => 1,
            'intro' => 'For more than 28 years, All Star Health Spine & Joint Care has helped patients across Gilbert, Tempe, Chandler, Mesa and surrounding Arizona communities live with less pain and move with more freedom.',
            'content' => '<h2>Integrated care under one roof</h2><p>Since approximately 1997, we have served our community with a patient-oriented approach to pain relief. Our team brings together board-certified medical providers, chiropractors, pain care specialists and physiotherapy and rehabilitation professionals — with more than 150 combined years of clinical experience.</p><p>Pain symptoms may be common, but the cause is different for every person. That is why we evaluate the whole patient and provide integrated, non-surgical care focused on pain relief, mobility, function and education.</p><h2>Our approach</h2><ul><li>Non-surgical orthopedic interventions</li><li>Chiropractic care</li><li>Tailored home physiotherapy programs</li><li>Patient education at every step</li></ul><p>Everything we do is focused on relieving pain, restoring mobility and improving quality of life.</p>',
            'meta_title' => 'About Us — Integrated Spine, Joint & Pain Care Since 1997',
            'meta_description' => 'All Star Health Spine & Joint Care has served Gilbert, Tempe, Chandler and Mesa for 28+ years with integrated, non-surgical spine, joint and pain care.',
        ],
        [
            'slug' => 'our-doctor', 'title' => 'Meet Our Providers', 'eyebrow' => 'Our Team', 'template' => 'providers', 'is_system' => 1,
            'intro' => 'Medical providers, chiropractors and rehabilitation professionals working together on your care — with more than 150 years of combined clinical experience.',
            'meta_title' => 'Meet Our Providers — Chiropractors, Physicians & PAs',
            'meta_description' => 'Meet the All Star Health care team: chiropractors, a family medicine physician and physician assistants serving Gilbert and Tempe, AZ.',
        ],
        [
            'slug' => 'testimonials', 'title' => 'Patient Stories', 'eyebrow' => 'Testimonials', 'template' => 'testimonials', 'is_system' => 1,
            'intro' => 'Hear from patients who have trusted All Star Health with their care.',
            'meta_title' => 'Patient Testimonials',
            'meta_description' => 'Read what patients say about their care at All Star Health Spine & Joint Care in Gilbert and Tempe, Arizona.',
        ],
        [
            'slug' => 'pain-treatments', 'title' => 'Pain Treatments', 'eyebrow' => 'All Treatments', 'template' => 'treatments', 'is_system' => 1,
            'intro' => 'Explore every treatment we offer — from regenerative medicine and injections to chiropractic, soft tissue, injury and allergy care.',
            'meta_title' => 'Pain Treatments — Non-Surgical Spine, Joint & Pain Care',
            'meta_description' => 'Browse all non-surgical treatments at All Star Health: injections, regenerative medicine, shockwave, spinal decompression, chiropractic, soft tissue, injury and allergy care.',
        ],
        [
            'slug' => 'make-appointment', 'title' => 'Request an Appointment', 'eyebrow' => 'Patient Center', 'template' => 'appointment', 'is_system' => 1, 'show_cta' => 0,
            'intro' => 'Tell us a little about what\'s going on and our team will reach out to confirm a time. Same-day appointments are available when possible.',
            'meta_title' => 'Request an Appointment',
            'meta_description' => 'Request an appointment at All Star Health in Gilbert or Tempe, AZ. Same-day appointments when available. Call or text 844-844-4755.',
        ],
        [
            'slug' => 'contact-us', 'title' => 'Contact Us', 'eyebrow' => 'Contact', 'template' => 'contact', 'is_system' => 1, 'show_cta' => 0,
            'intro' => 'Call, text or send us a message — our team is here to help you find the right place to start.',
            'meta_title' => 'Contact Us — Gilbert & Tempe Offices',
            'meta_description' => 'Contact All Star Health Spine & Joint Care. Call or text 844-844-4755. Offices in Gilbert and Tempe, Arizona.',
        ],
        [
            'slug' => 'locations', 'title' => 'Our Locations', 'eyebrow' => 'Locations', 'template' => 'locations', 'is_system' => 1,
            'intro' => 'Two convenient Arizona offices serving Gilbert, Tempe, Chandler, Mesa and the surrounding communities.',
            'meta_title' => 'Locations — Gilbert & Tempe, AZ',
            'meta_description' => 'Visit All Star Health in Gilbert (2730 S Val Vista Dr #188) or Tempe (6625 S Rural Rd #104). Hours, directions and maps.',
        ],
        [
            'slug' => 'billing-and-insurance', 'title' => 'Billing & Insurance', 'eyebrow' => 'Patient Center', 'template' => 'billing', 'is_system' => 1,
            'intro' => 'Not sure what your insurance covers? Start with a complimentary benefits check — we\'ll verify your coverage and explain your options.',
            'content' => '<p>Our insurance team works with most major commercial plans and Medicare. Before your first visit, we can verify your coverage, explain the benefits that may apply and help you understand your care options. If a service is not covered, we\'ll discuss payment options before treatment begins.</p>',
            'meta_title' => 'Billing & Insurance — Complimentary Benefits Check',
            'meta_description' => 'Most major insurance plans and Medicare accepted. Request a complimentary benefits check with All Star Health in Gilbert and Tempe, AZ.',
        ],
        [
            'slug' => 'your-first-visit', 'title' => 'Your First Visit', 'eyebrow' => 'Patient Guide', 'template' => 'default',
            'intro' => 'Knowing what to expect makes your first appointment easier. Here\'s how a first visit at All Star Health typically works.',
            'content' => '<h2>Before you arrive</h2><ul><li>Request an appointment online or call/text 844-844-4755.</li><li>Our team will run a complimentary benefits check with your insurance.</li><li>Download and complete your patient forms to save time at check-in.</li></ul><h2>At your visit</h2><p>We\'ll start with your patient information and health history, then a provider will perform an evaluation focused on your symptoms and goals.</p><h2>Your care plan</h2><p>Based on the evaluation, your provider will explain the findings and recommend a personalized plan. Many patients can begin treatment the same day when appropriate.</p><h2>What to bring</h2><ul><li>Photo ID and insurance card</li><li>Completed patient forms</li><li>A list of current medications</li><li>Any relevant imaging or medical records</li><li>Claim information if your visit relates to an accident or work injury</li></ul>',
            'meta_title' => 'Your First Visit — What to Expect',
            'meta_description' => 'What to expect at your first visit to All Star Health: benefits check, patient forms, evaluation and a personalized care plan.',
        ],
        [
            'slug' => 'phase-of-relief', 'title' => 'Phases of Care', 'eyebrow' => 'Patient Guide', 'template' => 'default', 'needs_review' => 1,
            'intro' => 'Care usually progresses through phases — from calming pain, to restoring function, to helping you stay well.',
            'content' => '<h2>1. Relief</h2><p>The first goal is to calm pain and inflammation so you can move more comfortably. Visits may be more frequent during this phase.</p><h2>2. Correction &amp; rehabilitation</h2><p>As symptoms improve, care shifts toward restoring mobility, strength and stability — often with exercises, stretches and soft tissue work you continue at home.</p><h2>3. Ongoing support</h2><p>Once you reach your goals, we\'ll recommend rehab, exercises, lifestyle guidance or maintenance care where appropriate — based on your needs, not a generic long-term program.</p>',
            'meta_title' => 'Phases of Care',
            'meta_description' => 'How care at All Star Health typically progresses: relief, correction and rehabilitation, and ongoing support.',
        ],
        [
            'slug' => 'privacy-policy', 'title' => 'Privacy Policy', 'eyebrow' => 'Legal', 'template' => 'legal', 'show_cta' => 0, 'needs_review' => 1,
            'intro' => 'How All Star Health Spine & Joint Care collects, uses and protects information submitted through this website.',
            'content' => '<h2>Information we collect</h2><p>When you submit a form on this website — for example to request an appointment, check your benefits or contact us — we collect the information you provide, such as your name, phone number, email address and message. We also collect basic, non-identifying usage information (such as pages visited) to improve the website.</p><h2>How we use information</h2><p>We use the information you submit to respond to your request, schedule appointments, verify benefits and communicate with you about your care. We do not sell your personal information.</p><h2>Protected health information</h2><p>Please do not submit detailed medical information through general website forms. Protected health information you share with us as a patient is handled in accordance with our Notice of Privacy Practices and applicable law, including HIPAA.</p><h2>Third-party services</h2><p>This website may use third-party services for forms, scheduling, chat, maps and analytics. These providers process information on our behalf according to their own privacy policies.</p><h2>Contact</h2><p>Questions about this policy? Call 844-844-4755.</p>',
            'meta_title' => 'Privacy Policy', 'meta_description' => 'Privacy policy for the All Star Health Spine & Joint Care website.',
        ],
        [
            'slug' => 'terms-and-conditions', 'title' => 'Terms & Conditions', 'eyebrow' => 'Legal', 'template' => 'legal', 'show_cta' => 0, 'needs_review' => 1,
            'intro' => 'The terms that apply to your use of this website.',
            'content' => '<h2>Website information</h2><p>The content on this website is provided for general educational purposes and is not medical advice. It is not a substitute for an evaluation by a qualified healthcare provider. Individual results vary, and eligibility for any treatment is determined after evaluation.</p><h2>Appointment requests</h2><p>Submitting an appointment request does not guarantee an appointment. Requested times must be confirmed by our office; requests may be held for 48 hours while confirmation is attempted.</p><h2>Emergencies</h2><p>Do not use this website for medical emergencies. If you are experiencing an emergency, call 911.</p><h2>Changes</h2><p>We may update these terms from time to time. Continued use of the website means you accept the current terms.</p>',
            'meta_title' => 'Terms & Conditions', 'meta_description' => 'Terms and conditions for the All Star Health Spine & Joint Care website.',
        ],
        [
            'slug' => 'sitemap', 'title' => 'Sitemap', 'eyebrow' => 'Sitemap', 'template' => 'sitemap', 'is_system' => 1, 'show_cta' => 0,
            'intro' => 'Every page on the All Star Health website in one place.',
            'meta_title' => 'Sitemap', 'meta_description' => 'A complete list of pages on the All Star Health Spine & Joint Care website.',
        ],
    ];
}
