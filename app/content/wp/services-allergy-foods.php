<?php
/** Allergy and medical-food copy imported from the previous WordPress site (see services-medical-1.php). */

$whyAllergy = <<<'HTML'
<h3>Why allergy care matters at All Star Health</h3>
<p>What do allergies have to do with non-surgical orthopedic care? More than you might think. Seasonal, environmental and food allergies can trigger inflammation throughout the body. That inflammation does more than cause sneezing or itching. It can also aggravate joint pain, muscle stiffness and other orthopedic conditions. For some patients, undiagnosed allergies add to chronic inflammation that slows healing. Identifying and addressing these hidden triggers is part of our whole-body approach to reducing inflammation, improving mobility and supporting lasting relief.</p>
HTML;

// Product video shown on the Theramine, Trepadone and Percura pages of the old site.
$medicalFoodVideo = <<<'HTML'
<h3>Watch: medical foods explained</h3>
<div class="video-embed"><iframe src="https://www.youtube-nocookie.com/embed/A6EAz_GVfg0" title="Medical foods video" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
HTML;

$medicalFoodNote = 'Physician-prescribed medical foods are intended for use only under medical supervision. Our providers typically prescribe them with refills, and when taken as directed each bottle is about a one-month supply.';

return [
    'environmental-allergies' => [
        'excerpt' => 'Identify and manage reactions to pollen, mold, dust mites, pet dander and other everyday allergens, from symptom relief to long-term immunotherapy.',
        'hero_text' => 'Pollen, mold, dust mites and pet dander shouldn’t run your life. Find out what triggers your symptoms and how to manage them.',
        'what_is' => <<<HTML
<p>Environmental allergies are caused by everyday substances around you, indoors and outdoors, that your immune system mistakenly treats as harmful. When your body reacts to these allergens, it triggers symptoms that can affect your daily life.</p>
<h3>Common environmental allergens</h3>
<p>Environmental allergens are usually inhaled and are found in homes, schools, workplaces and outdoors:</p>
<ul>
<li><strong>Pollen</strong> from trees, grasses and weeds, especially in spring and fall</li>
<li><strong>Mold spores</strong>, which thrive in damp places such as bathrooms, basements, leaf piles and soil</li>
<li><strong>Dust mites</strong>, microscopic bugs that live in bedding, carpets and upholstered furniture</li>
<li><strong>Pet dander</strong>, tiny flakes of skin shed by cats, dogs and other furry animals</li>
<li><strong>Cockroach droppings</strong>, a significant trigger in urban areas</li>
</ul>
<p>Air pollution and smoke are not allergens themselves, but they can irritate the airways and make allergy symptoms worse.</p>
{$whyAllergy}
HTML,
        'conditions' => "Sneezing\nRunny or stuffy nose (allergic rhinitis)\nItchy, red or watery eyes\nPostnasal drip\nCoughing or wheezing\nFatigue from poor sleep",
        'how_it_works' => <<<'HTML'
<h3>Reducing your exposure</h3>
<p>You cannot avoid environmental allergens completely, but simple changes can reduce exposure and improve indoor air quality:</p>
<ul>
<li>Use HEPA filters to trap airborne pollen, dust mites and pet dander.</li>
<li>Keep windows closed during high pollen seasons.</li>
<li>Shower and change clothes after spending time outdoors.</li>
<li>Vacuum and dust regularly to limit dust and mold.</li>
<li>Keep pets out of the bedroom.</li>
<li>Use a dehumidifier to make it harder for mold to grow.</li>
</ul>
<h3>Treatment options</h3>
<ul>
<li>Antihistamines for quick relief</li>
<li>Nasal corticosteroids to reduce inflammation</li>
<li>Decongestants for congestion</li>
<li>Eye drops for itchy, watery eyes</li>
<li>Allergen immunotherapy (AIT), such as <a href="/service/allergy-shots-for-environmental-allergies/">allergy shots</a> or <a href="/service/allergy-drops-for-environmental-allergies/">allergy drops</a>, for long-term relief</li>
</ul>
HTML,
        'benefits' => "Identifies your specific triggers\nPractical steps to reduce exposure\nShort-term symptom relief options\nLong-term immunotherapy options\nPart of a whole-body approach to inflammation",
        'what_to_expect' => <<<'HTML'
<p>Our motto is "Test! Don't Guess!" We start by identifying the environmental allergens behind your symptoms, then build a personalized plan to reduce exposure, relieve symptoms and, when appropriate, retrain your immune response. Appointments are available at our Tempe and Gilbert locations.</p>
HTML,
        'faqs' => [
            ['What are the most common environmental allergens?', 'Pollen, mold spores, dust mites, pet dander and, in urban areas, cockroach droppings.'],
            ['How do I find out what I am allergic to?', 'Allergy testing, either skin or blood testing, can identify your specific triggers so treatment can be targeted.'],
            ['Is there a long-term option beyond medication?', 'Yes. Allergen immunotherapy, given as allergy shots or allergy drops, gradually helps your immune system become less sensitive to specific allergens.'],
        ],
        'meta_title' => 'Environmental Allergy Treatment in Gilbert & Tempe, AZ',
        'meta_description' => 'Identify and treat environmental allergies to pollen, mold, dust mites and pet dander at All Star Health, from symptom relief to immunotherapy.',
    ],

    'chronic-sinus-infections' => [
        'excerpt' => 'Evaluation and treatment for sinus inflammation lasting 12 weeks or longer, including allergy testing to find contributing triggers.',
        'hero_text' => 'Sinus symptoms that won’t go away? Find the underlying cause and build a plan for long-term sinus health.',
        'what_is' => <<<HTML
<p>A chronic sinus infection (chronic sinusitis) happens when your sinuses, the air-filled spaces behind your nose, cheeks and eyes, stay swollen and inflamed for 12 weeks or longer despite treatment. It can cause uncomfortable symptoms that affect daily life and may be linked to allergies or other health issues.</p>
<p>The symptoms often resemble a common cold, but they last much longer.</p>
{$whyAllergy}
HTML,
        'conditions' => "Nasal congestion\nThick, discolored mucus or postnasal drip\nFacial pain, pressure or fullness\nLoss of smell or taste\nHeadaches or tooth pain\nFatigue and poor sleep\nBad breath",
        'how_it_works' => <<<'HTML'
<h3>How it is diagnosed</h3>
<p>Your provider reviews your medical history, performs a physical exam and may recommend:</p>
<ul>
<li>Allergy testing to see whether allergies are contributing</li>
<li>Imaging, such as a CT scan, for detailed pictures of the sinuses</li>
<li>Nasal endoscopy, in which a small camera looks inside the sinuses</li>
<li>A sinus culture to identify a bacterial or fungal infection</li>
</ul>
<p>When specialized testing or procedures are needed, we coordinate referrals.</p>
<h3>Treatment options</h3>
<p>Chronic sinusitis often needs a combination of treatments matched to the cause. These may include nasal corticosteroid sprays to reduce swelling, saline rinses to clear mucus and allergens, antibiotics if a bacterial infection is present, and decongestants or antihistamines for allergy-related symptoms. Severe inflammation may call for oral or injected steroids. Allergy management, including immunotherapy, can reduce the allergic reactions that feed sinus problems. When other treatments fail, a referral for surgery to remove blockages or polyps may be considered.</p>
HTML,
        'benefits' => "Looks for the underlying cause, including allergies\nCombination treatment matched to your symptoms\nLong-term prevention strategies\nReferrals coordinated when needed",
        'what_to_expect' => <<<'HTML'
<h3>Managing and preventing flare-ups</h3>
<ul>
<li>Treat and manage underlying allergies or asthma.</li>
<li>Use a humidifier to keep the air moist.</li>
<li>Avoid smoke and air pollutants.</li>
<li>Stay hydrated.</li>
<li>Rinse your nasal passages regularly with saline.</li>
</ul>
HTML,
        'faqs' => [
            ['When is a sinus infection considered chronic?', 'When sinus inflammation and symptoms last 12 weeks or longer despite treatment.'],
            ['Can allergies cause chronic sinusitis?', 'Allergies can contribute to ongoing sinus inflammation, which is why allergy testing is often part of the evaluation.'],
        ],
        'meta_title' => 'Chronic Sinus Infection Treatment in Gilbert & Tempe, AZ',
        'meta_description' => 'Evaluation and treatment for chronic sinusitis at All Star Health, including allergy testing to find triggers and a plan for long-term sinus health.',
    ],

    'nasal-congestion' => [
        'excerpt' => 'Find out what is behind a stuffy nose that keeps coming back, from allergies and sinus infections to structural causes, and get relief.',
        'hero_text' => 'Breathe easier. Find the cause of persistent nasal congestion and a treatment plan that works.',
        'what_is' => <<<HTML
<p>Nasal congestion, or a stuffy nose, happens when the tissues inside the nose swell because of inflamed blood vessels. The blockage can make it hard to breathe through your nose and often comes with a runny nose or sinus pressure.</p>
<h3>What causes nasal congestion?</h3>
<ul>
<li>Colds, flu and other viral infections</li>
<li>Allergies to pollen, dust, pet dander or mold</li>
<li>Sinus infections (sinusitis)</li>
<li>Irritants such as smoke, pollution or strong odors</li>
<li>Nasal polyps or a deviated septum that physically block airflow</li>
<li>Overuse of decongestant nasal sprays, which can cause rebound congestion</li>
</ul>
{$whyAllergy}
HTML,
        'conditions' => "Difficulty breathing through the nose\nStuffy or blocked nose\nRunny nose\nSinus pressure or pain\nSnoring\nPostnasal drip and sore throat\nReduced sense of smell or taste",
        'how_it_works' => <<<'HTML'
<h3>How it is diagnosed</h3>
<p>If congestion lasts more than a week or keeps coming back, your provider may recommend a physical exam of the nose and throat, allergy testing to identify triggers, and, in some cases, imaging or a nasal endoscopy to check for sinus infection, polyps or other blockages.</p>
<h3>Treatment options</h3>
<ul>
<li>Decongestants (oral or nasal spray) to reduce swelling</li>
<li>Antihistamines for allergy-related congestion</li>
<li>Nasal corticosteroid sprays to reduce inflammation</li>
<li>Saline sprays or rinses to clear mucus and soothe tissue</li>
<li>Pain relievers such as acetaminophen or ibuprofen for headache or sinus pressure</li>
</ul>
<h3>Home remedies</h3>
<ul>
<li>Steam inhalation to loosen mucus</li>
<li>A humidifier to keep the air moist</li>
<li>Plenty of fluids to thin mucus</li>
<li>Saline irrigation with a neti pot or rinse bottle</li>
</ul>
HTML,
        'benefits' => "Identifies the underlying cause\nMedication and home-care options\nAllergy testing when allergies are suspected\nPrevention strategies to reduce recurrence",
        'what_to_expect' => <<<'HTML'
<h3>Preventing nasal congestion</h3>
<ul>
<li>Manage allergies by avoiding triggers and using medication as prescribed.</li>
<li>Avoid irritants such as smoke, pollution and strong perfumes.</li>
<li>Stay hydrated to keep mucus thin.</li>
<li>Wash your hands often to avoid viruses.</li>
<li>Use a humidifier, especially in dry conditions.</li>
</ul>
HTML,
        'faqs' => [
            ['When should I see a provider about congestion?', 'If it lasts more than a week, keeps coming back or comes with significant sinus pain or fever.'],
            ['Can nasal sprays make congestion worse?', 'Yes. Overusing decongestant nasal sprays can cause rebound congestion. Ask your provider how long to use them.'],
        ],
        'meta_title' => 'Nasal Congestion Treatment in Gilbert & Tempe, AZ',
        'meta_description' => 'Find the cause of persistent nasal congestion at All Star Health, from allergies to sinus problems, and get a treatment plan to breathe easier.',
    ],

    'hives-urticaria' => [
        'excerpt' => 'Evaluation and treatment for raised, itchy welts (hives), including identifying triggers and managing chronic or recurring outbreaks.',
        'hero_text' => 'Itchy welts that keep coming back? Identify your triggers and find lasting relief from hives.',
        'what_is' => <<<HTML
<p>Hives, also called urticaria, are raised, red, itchy welts or bumps on the skin. They vary in size, shape and location and often appear suddenly. Hives are uncomfortable but usually go away on their own. Chronic or severe cases may need medical attention.</p>
<h3>What causes hives?</h3>
<p>Hives occur when the body releases histamine and other chemicals in response to a trigger. Common triggers include:</p>
<ul>
<li>Allergic reactions to foods, medications, or insect stings and bites</li>
<li>Environmental allergens such as pollen, animal dander and mold</li>
<li>Physical triggers such as heat, cold, pressure or sunlight</li>
<li>Emotional stress</li>
<li>Infections such as colds, flu and other viral or bacterial illnesses</li>
<li>Chronic conditions, including some autoimmune and thyroid disorders</li>
</ul>
<p>Sometimes no cause can be found. This is called idiopathic urticaria.</p>
{$whyAllergy}
HTML,
        'conditions' => "Raised red or skin-colored welts\nItching, from mild to intense\nWelts that change shape, move or reappear\nSwelling around the welts (angioedema)\nWelts with a pale center and red border",
        'how_it_works' => <<<'HTML'
<h3>How hives are diagnosed</h3>
<ul>
<li><strong>Physical exam</strong> to evaluate the welts and check for other conditions</li>
<li><strong>Medical history</strong> covering recent illness, allergies, medications and possible triggers</li>
<li><strong>Allergy testing</strong> (skin or blood tests) when an allergy is suspected</li>
<li><strong>Skin biopsy</strong>, rarely, to rule out other skin conditions</li>
</ul>
<h3>Treatment options</h3>
<ul>
<li><strong>Antihistamines</strong>, the first line of treatment, block the histamine that causes hives and itching.</li>
<li><strong>Corticosteroids</strong>, oral or topical, may be used for severe or persistent cases.</li>
<li><strong>Epinephrine</strong> is required immediately if hives come with difficulty breathing or swelling of the lips, tongue or throat (anaphylaxis). Call 911.</li>
</ul>
<h3>Home care</h3>
<ul>
<li>Cool compresses to soothe itching</li>
<li>Oatmeal baths to calm the skin</li>
<li>Loose, soft clothing to avoid irritation</li>
<li>Avoiding known triggers</li>
</ul>
HTML,
        'benefits' => "Identifies possible triggers\nRelief from itching and swelling\nPlan for chronic or recurring hives\nAllergy testing when an allergy is suspected",
        'what_to_expect' => <<<'HTML'
<h3>Reducing flare-ups</h3>
<p>Hives cannot always be prevented, but these steps may help:</p>
<ul>
<li>Identify and avoid your triggers, such as certain foods, medications or environmental factors.</li>
<li>Manage stress with relaxation techniques such as yoga, deep breathing or meditation.</li>
<li>Use mild soaps and lotions and avoid harsh chemicals.</li>
</ul>
HTML,
        'faqs' => [
            ['When are hives an emergency?', 'If hives come with difficulty breathing or swelling of the lips, tongue or throat, call 911. These can be signs of anaphylaxis.'],
            ['Why do my hives keep coming back?', 'Recurring hives can have many triggers, and sometimes no cause is found. An evaluation and, when appropriate, allergy testing can help identify triggers.'],
        ],
        'meta_title' => 'Hives (Urticaria) Treatment in Gilbert & Tempe, AZ',
        'meta_description' => 'Evaluation and treatment for hives at All Star Health, including identifying triggers and relief for chronic or recurring urticaria.',
    ],

    'allergy-testing' => [
        'excerpt' => 'Skin and blood allergy testing to pinpoint exactly what you are allergic to, so treatment can be targeted and effective.',
        'hero_text' => 'Test! Don’t Guess! Find out exactly what triggers your allergy symptoms so your treatment can be targeted.',
        'what_is' => <<<HTML
<p>If you have allergy symptoms like sneezing, itchy eyes, skin rashes or breathing difficulties, it can be hard to tell exactly what is causing them. Allergy testing identifies what you are allergic to, whether it is pollen, pet dander, mold, certain foods or another allergen.</p>
<p>Testing also helps gauge how severe your allergies are, from mild irritation to potentially life-threatening reactions, and shows which treatments are likely to work best. Knowing your triggers lets you take the right precautions and can significantly improve your quality of life.</p>
{$whyAllergy}
HTML,
        'conditions' => "Seasonal and environmental allergies\nFood allergies\nHives and skin reactions\nChronic sinus problems\nPersistent nasal congestion\nItchy, watery eyes",
        'how_it_works' => <<<'HTML'
<h3>Skin testing</h3>
<p>Skin testing options include the <strong>prick test</strong>, in which allergens are placed on the skin and lightly pricked to check for a reaction; the <strong>intradermal test</strong>, in which a small amount of allergen is injected just beneath the skin for more specific results; and the <strong>patch test</strong>, used for delayed reactions, in which allergens stay on the skin for 48 hours.</p>
<h3>Blood testing</h3>
<p>Blood tests measure IgE antibodies to specific allergens. A specific IgE blood test (such as RAST or ImmunoCAP) helps identify common allergies and is a good option for people who cannot have skin testing.</p>
HTML,
        'benefits' => "Pinpoints your specific triggers\nHelps gauge allergy severity\nGuides the most effective treatment\nSkin and blood testing options\nSkin test results are usually available the same visit",
        'what_to_expect' => <<<'HTML'
<p>Your provider first reviews your medical history, symptoms and possible allergens. Testing then typically goes like this:</p>
<ul>
<li><strong>Preparation.</strong> The test area, often the forearm or back, is cleaned.</li>
<li><strong>Testing.</strong> For skin testing, small drops of allergen are placed on the skin, which is then pricked or injected. For blood testing, a small sample is drawn from your arm.</li>
<li><strong>Results.</strong> Skin test results are usually ready within about 20 minutes. Blood test results may take a few days.</li>
<li><strong>Follow-up.</strong> Your provider reviews the results with you and recommends a plan. This may include avoiding allergens, medications such as antihistamines, decongestants and eye drops, or immunotherapy.</li>
</ul>
HTML,
        'faqs' => [
            ['How long does skin testing take?', 'Skin test results are usually available within about 20 minutes.'],
            ['What if I cannot have skin testing?', 'A specific IgE blood test is a good alternative for people who cannot undergo skin testing.'],
            ['What happens after testing?', 'Your provider reviews your results and recommends a plan, which may include avoiding allergens, medication or allergen immunotherapy.'],
        ],
        'meta_title' => 'Allergy Testing in Gilbert & Tempe, AZ',
        'meta_description' => 'Skin and blood allergy testing at All Star Health pinpoints your triggers so your allergy treatment can be targeted and effective.',
    ],

    'food-allergies' => [
        'excerpt' => 'Identify food allergies, understand your symptoms and build a plan to stay safe, from label reading to emergency preparedness.',
        'hero_text' => 'Know what is safe to eat. Identify food allergies and build a plan to manage them with confidence.',
        'what_is' => <<<HTML
<p>A food allergy happens when your immune system mistakes a normally harmless food for a threat. In response, your body releases chemicals such as histamine, causing symptoms that range from mild to severe. Food allergies are common and can affect people of all ages.</p>
<p>Symptoms can appear within minutes to a few hours after eating the food. Allergy testing can help identify which foods are responsible and how severe the allergy is.</p>
{$whyAllergy}
HTML,
        'conditions' => "Hives, redness or swelling, often around the face, lips or tongue\nItching or tingling in the mouth or throat\nStomach pain, cramps, diarrhea or vomiting\nWheezing, coughing, congestion or difficulty breathing\nSwelling of the face, throat or tongue\nAnaphylaxis",
        'how_it_works' => <<<'HTML'
<h3>Avoidance</h3>
<ul>
<li>Read food labels carefully to identify allergens.</li>
<li>Ask questions when dining out or eating prepared foods.</li>
<li>Prevent cross-contamination by thoroughly cleaning cooking surfaces and utensils.</li>
</ul>
<h3>Medications</h3>
<ul>
<li><strong>Antihistamines</strong> can treat mild reactions such as hives or itching.</li>
<li><strong>Epinephrine</strong> is the first-line treatment for severe reactions (anaphylaxis). People with severe food allergies should carry an epinephrine auto-injector at all times.</li>
</ul>
HTML,
        'benefits' => "Identifies problem foods\nClear guidance on avoidance\nEmergency preparedness for severe reactions\nTesting to understand severity",
        'what_to_expect' => <<<'HTML'
<p>Anaphylaxis is a severe, life-threatening reaction that can cause throat swelling, difficulty breathing, a drop in blood pressure and loss of consciousness. It requires epinephrine and emergency care right away. Call 911.</p>
<p>At your visit, your provider reviews your history and symptoms, recommends appropriate testing and helps you build a plan to manage your allergy safely.</p>
HTML,
        'faqs' => [
            ['How quickly do food allergy symptoms appear?', 'Usually within minutes to a few hours after eating the food.'],
            ['What should I do in a severe reaction?', 'Use your epinephrine auto-injector if you have one and call 911 immediately.'],
        ],
        'meta_title' => 'Food Allergy Testing & Care in Gilbert & Tempe, AZ',
        'meta_description' => 'Identify and manage food allergies at All Star Health with testing, avoidance strategies and emergency preparedness for severe reactions.',
    ],

    'allergy-shots-for-environmental-allergies' => [
        'excerpt' => 'Allergen immunotherapy shots that gradually train your immune system to react less to pollen, dust mites, mold and pet dander.',
        'hero_text' => 'Reduce your reliance on allergy medications with immunotherapy that gradually desensitizes your immune system.',
        'what_is' => <<<HTML
<p>Allergy shots, also called allergen immunotherapy, treat environmental allergies such as pollen, pet dander, dust mites and mold. You receive regular injections of small amounts of the allergens that trigger your symptoms. Over time, the goal is to train your immune system to become less sensitive to those allergens, reducing your reactions and improving your quality of life.</p>
{$whyAllergy}
HTML,
        'conditions' => "Persistent symptoms despite medication\nPollen allergies\nMold allergies\nPet dander allergies\nDust mite allergies\nAllergens that are hard to avoid at home or work",
        'how_it_works' => <<<'HTML'
<p>Each shot contains a very small dose of allergen, and the dose is increased gradually to help your immune system build tolerance. Treatment has two phases.</p>
<h3>Build-up phase</h3>
<p>You receive shots once or twice a week, starting with low doses that increase gradually. This controlled approach introduces your immune system to the allergen while limiting reactions. This phase usually lasts three to six months.</p>
<h3>Maintenance phase</h3>
<p>Once you reach your target dose, shots become less frequent, typically every two to four weeks. This phase maintains your desensitization and keeps symptoms under control. Most people stay in maintenance for three to five years.</p>
HTML,
        'benefits' => "Treats the immune response, not just the symptoms\nCan reduce reliance on allergy medication\nTargets your specific allergens\nMonitored in the office for safety",
        'what_to_expect' => <<<'HTML'
<ul>
<li><strong>Before starting.</strong> Your provider reviews your allergy history and uses skin or blood testing to identify your specific triggers.</li>
<li><strong>During each visit.</strong> The shot is given under the skin, usually in the upper arm. It takes only a few minutes, but you will wait in the office for 20 to 30 minutes afterward so we can watch for any immediate reaction.</li>
<li><strong>After the shot.</strong> Most people have no side effects or only minor ones, such as redness or swelling at the injection site.</li>
</ul>
<h3>Possible side effects</h3>
<p>Allergy shots are generally safe. Mild side effects can include redness or swelling at the injection site, itchy eyes, nose or throat, and sneezing or a runny nose. Rarely, more serious reactions such as severe swelling, difficulty breathing or anaphylaxis can occur. That is why you are monitored after every injection. Seek immediate medical attention for any severe symptom.</p>
HTML,
        'faqs' => [
            ['Who is a good candidate for allergy shots?', 'People with year-round or seasonal environmental allergies whose symptoms are not controlled by over-the-counter medication or avoidance, and who do not have severe asthma or other conditions that make shots risky.'],
            ['How long does treatment last?', 'The build-up phase usually lasts three to six months. Most people then continue maintenance shots every two to four weeks for three to five years.'],
            ['Why do I have to wait after each shot?', 'Serious reactions are rare but possible, so we monitor you for 20 to 30 minutes after each injection.'],
        ],
        'meta_title' => 'Allergy Shots (Immunotherapy) in Gilbert & Tempe, AZ',
        'meta_description' => 'Allergy shots at All Star Health gradually desensitize your immune system to pollen, dust mites, mold and pet dander for longer-term relief.',
    ],

    'allergy-drops-for-environmental-allergies' => [
        'excerpt' => 'Sublingual immunotherapy (SLIT): allergy drops taken under the tongue at home to gradually desensitize your immune system, without injections.',
        'hero_text' => 'A convenient, needle-free, at-home alternative to allergy shots for pollen, dust mites, mold and pet dander allergies.',
        'what_is' => <<<HTML
<p>Allergy drops, also called sublingual immunotherapy (SLIT), are an alternative to allergy shots for environmental allergies. Drops containing small amounts of allergen are placed under the tongue, where they are absorbed. Over time, the goal is to help your immune system build tolerance and reduce your symptoms.</p>
<p>Unlike allergy shots, which are given in a provider's office, allergy drops are a convenient at-home treatment. They are commonly used for allergies to pollen, dust mites, mold and pet dander.</p>
{$whyAllergy}
HTML,
        'conditions' => "Moderate to severe environmental allergies\nPollen, dust mite, mold and pet dander allergies\nPatients who prefer not to receive injections\nPatients who want to rely less on allergy medication",
        'how_it_works' => <<<'HTML'
<h3>Build-up phase</h3>
<p>You start with a low dose taken daily under the tongue, and the dose increases gradually. This phase typically lasts a few months.</p>
<h3>Maintenance phase</h3>
<p>Once you reach your target dose, the dose stays the same. You continue taking the drops daily, typically for three to five years, to maintain your tolerance.</p>
HTML,
        'benefits' => "Needle-free\nTaken conveniently at home\nMay significantly reduce sneezing, congestion and itchy eyes\nCan reduce reliance on allergy medication\nRelief may continue after treatment ends",
        'what_to_expect' => <<<'HTML'
<ul>
<li><strong>Before starting.</strong> Your provider identifies your allergens and creates a personalized treatment plan.</li>
<li><strong>Daily drops.</strong> You place the drops under your tongue each day, following the instructions carefully so they absorb properly.</li>
<li><strong>Monitoring.</strong> Your provider tracks your progress and may adjust the dose over time.</li>
</ul>
<h3>Possible side effects</h3>
<p>Most people have few or no side effects, especially once their body adjusts. Mild effects can include an itchy mouth, throat or ears, mild swelling or irritation in the mouth, and sneezing or a runny nose. Severe reactions such as anaphylaxis are rare, which is why you are monitored closely early in treatment. Seek immediate care for severe swelling of the mouth, lips, tongue or throat, or difficulty breathing.</p>
HTML,
        'faqs' => [
            ['How are allergy drops different from allergy shots?', 'Both are forms of immunotherapy. Drops are taken under the tongue at home, while shots are given as injections in the office.'],
            ['How long will I take allergy drops?', 'After a build-up phase of a few months, most people continue daily drops for three to five years.'],
            ['Who is a good candidate?', 'People with moderate to severe environmental allergies who want a convenient, needle-free option or want to rely less on allergy medication.'],
        ],
        'meta_title' => 'Allergy Drops (Sublingual Immunotherapy) in Gilbert & Tempe, AZ',
        'meta_description' => 'Allergy drops (SLIT) from All Star Health are a needle-free, at-home immunotherapy for pollen, dust mite, mold and pet dander allergies.',
    ],

    'theramine' => [
        'excerpt' => 'A physician-prescribed medical food for the dietary management of chronic pain. It is non-addictive and is not an NSAID or opioid.',
        'hero_text' => 'A non-addictive, physician-prescribed medical food for the dietary management of chronic back, joint and muscle pain.',
        'what_is' => <<<'HTML'
<p>Theramine® is a physician-formulated medical food for the dietary management of chronic pain. It is designed for people with back, joint and muscle discomfort and is not an NSAID or an opioid. According to the manufacturer, Theramine addresses the nutritional deficiencies that can perpetuate chronic pain, and it has been studied in two double-blind clinical trials as both a standalone and an add-on therapy.</p>
<p>Chronic pain changes how the nervous system uses nutrients, amino acids and neurotransmitters. Theramine provides specific amino acids that support the neurotransmitters involved in dampening pain signals. Studies have reported reductions in the inflammatory markers C-reactive protein (CRP) and interleukin-6 (IL-6).</p>
<h3>Key ingredients</h3>
<ul>
<li><strong>GABA</strong>, the main inhibitory neurotransmitter in the central nervous system, which helps balance the excitatory signals involved in pain transmission</li>
<li><strong>Choline bitartrate</strong>, converted in the body to acetylcholine, which supports serotonin release and helps reduce sensitivity to pain</li>
<li><strong>L-arginine</strong>, which supports nitric oxide production, involved in pain signaling</li>
<li><strong>L-histidine</strong>, which supports the histamine system's role in reducing pain signal transmission</li>
<li><strong>5-HTP</strong>, a precursor to serotonin, which plays a role in pain modulation</li>
</ul>
<h3>Research</h3>
<p>Shell WE, et al. "A Double-Blind Controlled Trial of a Single Dose Naproxen and an Amino Acid Medical Food Theramine for the Treatment of Low Back Pain." <em>American Journal of Therapeutics</em>, 2012.</p>
<p>Shell WE, et al. "Reduction in Pain and Inflammation Associated with Chronic Low Back Pain with the Use of the Medical Food Theramine." <em>American Journal of Therapeutics</em>.</p>
HTML . $medicalFoodVideo,
        'conditions' => "Acute pain\nChronic pain\nInflammatory pain\nNeuropathic pain\nIdiopathic pain, such as fibromyalgia\nBack, joint and muscle pain",
        'how_it_works' => <<<'HTML'
<p>Theramine is a capsule taken by mouth. It contains a proprietary blend of amino acids and polyphenol ingredients for the dietary management of the altered metabolic processes associated with pain syndromes and inflammatory conditions. It is designed to support the production of serotonin, GABA, serine and acetylcholine, neurotransmitters involved in reducing pain and inflammation.</p>
<p>The ingredients are Generally Recognized as Safe (GRAS). Clinical experience suggests Theramine may allow the dose of other pain medications to be lowered, under physician supervision.</p>
HTML,
        'benefits' => "Non-addictive, with no reports of addiction in clinical use\nNot an NSAID or opioid\nCan be used alone or alongside other therapies\nDeveloped by physicians specializing in cardiology, rheumatology and integrative medicine\nMade with ingredients Generally Recognized as Safe (GRAS)",
        'what_to_expect' => <<<HTML
<p>The usual recommendation is two capsules twice a day. Your provider will determine the right dose for your condition. You must remain under a physician's ongoing supervision while taking Theramine.</p>
<p>{$medicalFoodNote}</p>
HTML,
        'faqs' => [
            ['Is Theramine a drug?', 'No. Theramine is a medical food, a specially formulated nutritional product used under physician supervision for the dietary management of pain. It is not an NSAID or an opioid.'],
            ['Is it safe?', 'Theramine should not be used by people with hypersensitivity to any of its ingredients. Very high doses of its amino acids (15 to 30 grams a day) can cause nausea, cramps and diarrhea, although each capsule contains no more than 400 mg of amino acids in total. Some patients may notice these symptoms at lower doses.'],
            ['Does it interact with my medications?', 'Theramine does not directly affect how prescription drugs are processed. Under physician supervision, it may allow the doses of other medications to be lowered. Always tell your provider about everything you take.'],
        ],
        'meta_title' => 'Theramine® Medical Food for Chronic Pain | Gilbert & Tempe, AZ',
        'meta_description' => 'Theramine® is a physician-prescribed, non-addictive medical food for the dietary management of chronic pain, available through All Star Health.',
    ],

    'trepadone' => [
        'excerpt' => 'A physician-prescribed medical food for the nutritional needs of chronic joint disorders such as osteoarthritis, with glucosamine and chondroitin.',
        'hero_text' => 'A physician-prescribed medical food formulated for the nutritional needs of joint pain and inflammation in conditions like osteoarthritis.',
        'what_is' => <<<'HTML'
<p>Trepadone® is a physician-developed medical food formulated for the distinct nutritional needs of chronic joint disorders such as osteoarthritis. According to the manufacturer, it supports the body's ability to manage joint pain and inflammation and helps maintain mobility and flexibility over time, without the gastrointestinal and cardiovascular risks associated with NSAIDs.</p>
<p>Chronic pain is often associated with faster turnover of the amino acids and neurotransmitters the nervous system needs to dampen pain and inflammatory signals. Trepadone is designed to meet those needs in joint disorders.</p>
<h3>Key ingredients</h3>
<ul>
<li><strong>Glucosamine sulfate</strong>, a building block of cartilage that contributes to joint strength, elasticity and resistance to compression</li>
<li><strong>Chondroitin sulfate</strong>, a large molecule found in cartilage that has been studied for its anti-inflammatory effects and its role in slowing cartilage breakdown</li>
<li><strong>L-histidine</strong>, an amino acid with anti-inflammatory and immune-modulating properties</li>
<li><strong>Whey protein</strong>, whose peptides have been studied for effects on pain and inflammation</li>
</ul>
HTML . $medicalFoodVideo,
        'conditions' => "Osteoarthritis\nChronic joint pain\nJoint inflammation\nJoint stiffness and reduced mobility",
        'how_it_works' => <<<'HTML'
<p>Trepadone provides a balance of nutrients involved in managing pain and inflammation. Its blend of antioxidants and anti-inflammatory ingredients helps limit the effects of joint inflammation. Glucosamine and chondroitin help maintain the structure and function of the joints.</p>
<p>It does not directly affect how prescription drugs are processed. Under physician supervision, it may allow the doses of other medications to be lowered.</p>
HTML,
        'benefits' => "Formulated specifically for joint disorders\nContains glucosamine and chondroitin\nNot an NSAID or opioid\nNon-habit-forming\nMade with ingredients Generally Recognized as Safe (GRAS)",
        'what_to_expect' => <<<HTML
<p>The usual recommendation is two capsules twice a day, between meals. The capsules can be opened and mixed with juice or another flavored drink, or with oatmeal or applesauce, to make them easier to take.</p>
<p>{$medicalFoodNote}</p>
HTML,
        'faqs' => [
            ['Does Trepadone contain allergens?', 'Yes. Trepadone contains fish (tuna), shellfish (shrimp, crab and crayfish) and milk (hydrolyzed whey protein isolate). Do not take it if you are allergic to any of these.'],
            ['Is Trepadone right for me?', 'Your provider can help you decide whether Trepadone fits your condition. It is designed for pain and inflammation related to joint disorders.'],
            ['Are there side effects?', 'Trepadone should not be used by anyone with hypersensitivity to its ingredients. Very high doses of amino acids can cause nausea, cramps or diarrhea, but Trepadone contains well under those amounts. Some sensitive patients may still notice mild symptoms.'],
        ],
        'meta_title' => 'Trepadone® Medical Food for Joint Pain | Gilbert & Tempe, AZ',
        'meta_description' => 'Trepadone® is a physician-prescribed medical food with glucosamine and chondroitin for the dietary management of joint pain and osteoarthritis.',
    ],

    'percura' => [
        'excerpt' => 'A physician-prescribed medical food for the dietary management of peripheral neuropathy, including pain, numbness and loss of sensation.',
        'hero_text' => 'A non-drug, non-addictive medical food formulated for the nutritional needs of peripheral neuropathy.',
        'what_is' => <<<'HTML'
<p>Percura® is a physician-developed medical food for the dietary needs of people with peripheral neuropathy, including pain, numbness and loss of sensation. Formulated with targeted amino acids and botanicals, it aims to address the metabolic imbalances in nerve function caused by chronic inflammation and nerve damage. Percura is not an NSAID, an opioid or an anti-epileptic medication.</p>
<p>Pain and inflammation increase the body's turnover of nutrients such as arginine, choline, GABA, glutamine, histidine, 5-hydroxytryptophan and serine. Simple dietary changes may not be enough to meet that increased demand. Percura is designed to supply the nutrients the nervous system needs for healthy nerve signaling.</p>
<h3>Key ingredients</h3>
<ul>
<li><strong>L-ornithine</strong>, an amino acid involved in nerve signaling and in lipid and amino acid metabolism</li>
<li><strong>Inositol</strong>, important for many cellular functions, including the development and function of peripheral nerves</li>
<li><strong>L-arginine</strong>, which supports nitric oxide production, peripheral blood flow and nerve health</li>
<li><strong>Creatine monohydrate</strong>, which supports cellular energy production and may aid repair in peripheral sensory nerves</li>
<li><strong>Choline bitartrate</strong>, converted to acetylcholine, which supports serotonin release and helps reduce sensitivity to pain</li>
</ul>
HTML . $medicalFoodVideo,
        'conditions' => "Peripheral neuropathy\nNerve pain\nNumbness\nLoss of sensation\nTingling in the hands or feet",
        'how_it_works' => <<<'HTML'
<p>Percura works with your body over time to meet the increased nutritional needs of neuropathic pain, helping restore balance to the nervous system. Its ingredients are Generally Recognized as Safe (GRAS). It may suit patients who have had significant side effects from certain drug therapies.</p>
HTML,
        'benefits' => "Drug-free support for peripheral nerves\nNot an NSAID, opioid or anti-epileptic\nDesigned for long-term use\nDeveloped by physicians specializing in cardiology, rheumatology and integrative medicine\nMade with ingredients Generally Recognized as Safe (GRAS)",
        'what_to_expect' => <<<HTML
<p>The usual recommendation is two capsules twice a day, between meals. Your provider will determine the right dose for you.</p>
<p>{$medicalFoodNote}</p>
HTML,
        'faqs' => [
            ['Is Percura a medication?', 'No. Percura is a medical food, a nutritional product used under physician supervision for the dietary management of peripheral neuropathy.'],
            ['Are there side effects?', 'Percura should not be used by anyone with hypersensitivity to its ingredients. Very high doses of L-arginine (15 to 30 grams a day) can cause nausea, cramps and diarrhea, although each capsule contains no more than 400 mg of amino acids. Some patients may notice these symptoms at lower doses.'],
            ['Does Percura interact with my medications?', 'Percura does not directly affect how prescription drugs are processed. Always tell your provider about everything you take.'],
        ],
        'meta_title' => 'Percura® Medical Food for Neuropathy | Gilbert & Tempe, AZ',
        'meta_description' => 'Percura® is a physician-prescribed medical food for the dietary management of peripheral neuropathy, including pain, numbness and loss of sensation.',
    ],
];
