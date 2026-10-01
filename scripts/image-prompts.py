#!/usr/bin/env python3
"""Generates docs/image-prompts/: one ChatGPT image prompt per treatment and site image.

Run:  python3 scripts/image-prompts.py
"""
import os, textwrap

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT = os.path.join(ROOT, 'docs', 'image-prompts')

STYLE = """COMPOSITION: {format}. Keep the main subject inside the central 60% of the frame with generous breathing room on every side — the website crops this image to 16:9 on treatment cards and to 5:4 in the page header. Eye-level or slightly elevated camera, 35–50 mm lens look, shallow depth of field (around f/2.8), clean and uncluttered background.

LIGHT & COLOR: Bright, soft natural daylight from large windows; calm, warm, trustworthy mood. Modern clinic palette of white, light warm grey and pale natural wood, with subtle deep-navy (#0C2D5E) accents (scrubs, upholstery, equipment trim) and at most one small touch of coral red (#E23744). Gentle shadows, true-to-life skin tones, no blue/green medical color cast.

PEOPLE: {people}

STYLE: Photorealistic editorial healthcare photography, like a premium medical brand campaign shot on a full-frame camera. Natural skin texture, anatomically correct hands and fingers, realistic medical equipment.

MUST AVOID: any text, letters, numbers, logos, watermarks, brand names, labels on bottles or packaging, or readable screens; blood, open wounds, graphic needle close-ups or needles piercing skin in sharp focus; exaggerated pain expressions; before/after imagery; surgery, operating rooms or hospital beds; people posing or grinning at the camera; cartoon, illustration or 3D-render look."""

PEOPLE_DEFAULT = "Real-looking, relaxed adults of varied ages and ethnicities. Clinicians wear navy scrubs or a clean white coat and nitrile gloves where clinically appropriate. The patient looks comfortable and at ease."

CATS = {
    'medical': 'Medical Treatments', 'soft-tissue': 'Soft Tissue Management', 'injury': 'Injury & Accident Care',
    'chiropractic': 'Chiropractic Care', 'allergy': 'Allergy Treatments', 'medical-foods': 'Medical Foods',
}

# slug, title, category, scene, people override (None = default), note
TREATMENTS = [
    ('trigger-point-and-joint-injections', 'Trigger Point & Joint Injections', 'medical',
     "A physician's gloved hands gently cleaning the skin over a patient's upper shoulder (trapezius) with an antiseptic swab before an injection. A small capped syringe rests on a sterile tray in soft focus. The patient sits upright on a modern treatment chair, seen from behind and slightly to the side, shoulder relaxed.",
     None, ''),
    ('ultrasound-guided-injections-and-diagnostics', 'Ultrasound Guided Injections & Diagnostics', 'medical',
     "A clinician gliding a handheld ultrasound probe with clear gel over the side of a patient's knee while the patient lies comfortably on a treatment table. A compact ultrasound monitor in the soft-focus background shows an abstract grayscale scan (no text or numbers on screen).",
     None, ''),
    ('regenerative-medicine', 'Regenerative Medicine', 'medical',
     "Close-up of a clinician's gloved hands placing clear, amber-tinted sample tubes into a sleek modern laboratory centrifuge in a bright clinical lab corner. Clean, high-tech and calm; subtle blue-navy equipment accents. No blood visible, no labels on tubes.",
     "One clinician, seen from the shoulders down (hands and forearms in gloves and navy scrubs).", ''),
    ('shockwave-therapy', 'Shockwave Therapy', 'medical',
     "A therapist holding a modern handheld acoustic shockwave applicator against the arch and heel of a patient's bare foot, a thin layer of clear gel visible. The patient lies on a padded treatment table; only the lower leg and foot are in sharp focus.",
     None, ''),
    ('pens-dry-needling-treatment', 'PENS / Dry Needling Treatment', 'medical',
     "A patient lying face-down on a treatment table with a towel draped over the lower body. Several very fine, thin filament needles sit in the muscles of the lower back, connected by thin wires to small clips and a compact electrical stimulation unit on a side cart. Calm and clinical; the needles are delicate and not the visual focus — the scene reads as relaxing therapy.",
     "One patient (face not visible) and the gloved hand of a clinician adjusting the stimulation unit.", ''),
    ('knee-pain-relief', 'Knee Pain Relief & Treatment', 'medical',
     "A clinician kneeling beside a patient seated on the edge of a treatment table, gently examining and bending the patient's knee with both hands to assess its range of motion. The patient (late 50s, athletic clothing) watches calmly.",
     None, ''),
    ('disc-injury-treatment', 'Disc Injury Treatment', 'medical',
     "A clinician holding a detailed anatomical model of the lumbar spine with intervertebral discs, pointing to a disc while explaining it to an attentive patient seated across a small consultation table. The spine model is the sharpest point of focus.",
     None, ''),
    ('spinal-decompression-therapy', 'Spinal Decompression Therapy', 'medical',
     "A patient lying relaxed on a modern computerized spinal decompression table with a padded harness around the lower torso, eyes closed, while a clinician adjusts a sleek control panel (screen shows no readable text). Spacious, calm treatment room.",
     None, ''),
    ('durable-medical-equipment', 'Durable Medical Equipment', 'medical',
     "A neat, minimal display of orthopedic support equipment on a light wood shelf and counter in a clinic: a hinged knee brace, a lumbar support belt, a wrist brace and an ankle support, all in neutral black/grey/navy without any visible branding or labels.",
     "No people.", ''),
    ('pit-treatment', 'PIT Treatment', 'medical',
     "A medical provider in a white coat sitting with a patient in a bright, modern treatment room, explaining an in-office treatment plan using a tablet (screen not visible). Friendly, professional conversation; a padded treatment table in the background.",
     None, 'Generic consultation image — replace with a specific photo once the treatment content is confirmed.'),
    ('iv-therapy', 'IV Therapy', 'medical',
     "A calm, empty modern infusion lounge: a comfortable reclining treatment chair in soft grey upholstery with navy accents, an IV pole with an empty bag beside it, a small side table with a glass of water and a folded blanket, large window with soft daylight.",
     "No people.", 'IV Therapy is "Coming Soon" — an empty, welcoming lounge works best.'),

    ('soft-tissue-management', 'Soft Tissue Management', 'soft-tissue',
     "A therapist's hands performing hands-on soft tissue work on a patient's upper back and shoulder blade area while the patient lies face-down on a treatment table, towel draped at the waist.",
     None, ''),
    ('active-passive-stretching', 'Active & Passive Stretching', 'soft-tissue',
     "A therapist assisting a patient lying on their back on a treatment table through a gentle hamstring stretch, supporting the straightened leg at the heel and knee. Both look focused and relaxed.",
     None, ''),
    ('myofascial-release', 'Myofascial Release', 'soft-tissue',
     "Close-up of a therapist's hands applying slow, sustained pressure with the palms and thumbs along the muscles beside a patient's lower spine, patient lying face-down. Emphasis on careful, precise touch.",
     None, ''),
    ('gua-sha-technique', 'Gua Sha Technique', 'soft-tissue',
     "A therapist gliding a smooth, polished stainless-steel instrument-assisted soft tissue tool along the muscles of a patient's forearm, skin with a light lotion sheen, forearm resting on a padded table.",
     None, ''),
    ('cupping-therapy', 'Cupping Therapy', 'soft-tissue',
     "Several clear silicone and glass cupping cups placed on a patient's upper back as they lie face-down on a treatment table; warm, soothing light, towel draped at the waist.",
     "One patient (face not visible) and optionally a therapist's hand placing a cup.", ''),
    ('theragun-therapy', 'Theragun Therapy', 'soft-tissue',
     "A therapist using a sleek, unbranded percussive massage device on the calf muscle of a patient lying face-down on a treatment table. Clean and modern, slight motion feel.",
     None, ''),

    ('car-accident-injury-treatment', 'Car Accident Injury Treatment', 'injury',
     "A clinician gently assessing the neck of a seated adult patient, one hand supporting the back of the head and the other on the shoulder as the patient slowly turns the head. Calm, reassuring and caring.",
     None, ''),
    ('work-injury-compensation', 'Work Injury / Workers Compensation', 'injury',
     "A clinician assessing the lower back of a standing patient who is a tradesperson, while a high-visibility work vest and a safety helmet rest on a chair nearby (no logos or text). Professional and supportive.",
     None, ''),
    ('sports-injuries-and-physical-fitness', 'Sports Injuries & Physical Fitness', 'injury',
     "An athletic patient with neat kinesiology tape on the shoulder performing a resistance-band rehab exercise while a clinician guides the movement, in a bright clinic rehab area with light gym equipment.",
     None, ''),

    ('chiropractic-therapy', 'Chiropractic Therapy', 'chiropractic',
     "A chiropractor performing a gentle hands-on spinal adjustment on a patient lying face-down on a modern padded chiropractic adjusting table, hands placed precisely on the mid-back. Professional, calm, premium clinic setting.",
     None, ''),

    ('allergy-drops-for-environmental-allergies', 'Allergy Drops — Environmental Allergies', 'allergy',
     "Close-up of a patient's hand holding a small amber glass dropper bottle (no label) with a single clear drop forming at the dropper tip, in a bright room with soft-focus blooming spring branches visible through the window.",
     "One adult, only hand and lower face partially visible, relaxed.", ''),
    ('allergy-shots-for-environmental-allergies', 'Allergy Shots — Environmental Allergies', 'allergy',
     "A nurse in navy scrubs with gloved hands cleaning a small area on a seated patient's upper arm with an antiseptic swab, a tray of small unlabeled vials in soft focus. Friendly, routine and calm.",
     None, ''),
    ('food-allergies', 'Food Allergies', 'allergy',
     "An elegant overhead flat-lay on white marble of common food allergens arranged neatly in small ceramic bowls: peanuts, tree nuts, eggs, a glass of milk, wheat ears and bread, shrimp, soybeans and sesame seeds.",
     "No people.", ''),
    ('allergy-testing', 'Allergy Testing', 'allergy',
     "A clinician's gloved hand performing an allergy skin-prick test on a patient's inner forearm: a neat grid of tiny marker dots and small clear droplets on the skin, a small applicator in hand. Clean, precise and clinical; no blood.",
     None, ''),
    ('hives-urticaria', 'Hives / Urticaria', 'allergy',
     "A provider gently examining mild, slightly raised pink patches on a patient's forearm under a soft examination light, the patient calm. Tasteful and non-alarming.",
     None, ''),
    ('nasal-congestion', 'Nasal Congestion', 'allergy',
     "An adult at home by a bright window holding a soft tissue near the nose, eyes slightly tired but calm, spring trees blooming in soft focus outside. Natural and relatable, not dramatic.",
     "One adult in casual clothing.", ''),
    ('chronic-sinus-infections', 'Chronic Sinus Infections', 'allergy',
     "An adult gently pressing the fingertips to the bridge of the nose and cheekbones (sinus area), eyes closed, in a calm, bright living space. Relatable discomfort, not distress.",
     "One adult in casual clothing.", ''),
    ('environmental-allergies', 'Environmental Allergies', 'allergy',
     "A backlit close-up of an Arizona palo verde tree in full yellow spring bloom with fine pollen glowing in the warm sunlight against a soft desert landscape and blue sky.",
     "No people.", ''),

    ('theramine', 'Theramine', 'medical-foods',
     "A clinician's hand placing a plain white unlabeled supplement bottle and a few capsules on a consultation desk beside a patient's folder (no readable text), in a bright modern office.",
     "Only the clinician's hand and forearm; patient blurred in background.", 'Do not reproduce any real product packaging.'),
    ('percura', 'Percura', 'medical-foods',
     "A minimal still life of a plain white unlabeled capsule bottle with a few capsules on a light wood surface next to an anatomical model of the foot showing nerves, in soft natural light.",
     "No people.", 'Do not reproduce any real product packaging.'),
    ('trepadone', 'Trepadone', 'medical-foods',
     "A minimal still life of a plain white unlabeled capsule bottle with a few capsules on a light wood surface next to an anatomical model of the knee joint, in soft natural light.",
     "No people.", 'Do not reproduce any real product packaging.'),

    ('whartons-jelly', "Wharton's Jelly", 'medical',
     "A clean, modern clinical lab bench with a few small clear sterile vials in a rack and a clinician's gloved hand, soft blue-navy accents, calm high-tech feel.",
     "Only gloved hands visible.", 'Optional — this page is a draft until the client confirms it.'),
    ('prolotherapy', 'Prolotherapy', 'medical',
     "A provider's gloved hands preparing a small capped syringe on a sterile tray beside a treatment table, a patient's knee in soft focus in the background.",
     None, 'Optional — this page is a draft until the client confirms it.'),
]

PAGES = [
    ('home-hero', 'Homepage hero', 'Homepage (top banner)', 'Portrait 2:3 (1024×1536)',
     "A chiropractor or rehab clinician guiding a smiling, healthy-looking patient in their 50s through a gentle shoulder-mobility movement in a bright, airy modern clinic. Large windows show a soft-focus Arizona desert landscape with mountains. Optimistic, active, 'move with more freedom' feeling.",
     PEOPLE_DEFAULT, 'The hero crops to roughly square — keep both people in the middle.'),
    ('home-integrated-care', 'Homepage “integrated care” section', 'Homepage, “Not Just Better Healthcare” section', 'Square 1:1 (1024×1024)',
     "Three clinicians — a physician in a white coat, a chiropractor and a physician assistant in navy scrubs — collaborating around an anatomical spine model and a tablet in a bright modern clinic, mid-discussion, engaged and friendly.",
     PEOPLE_DEFAULT + " These are illustrative people, not the actual staff.", 'Replace later with a real team photo if you have one.'),
    ('page-about-us', 'About page header', '/about-us/', 'Landscape 3:2 (1536×1024)',
     "A welcoming, modern clinic reception and waiting area with warm wood, soft grey seating, plants and large windows with Arizona daylight; calm and premium. No signage text.",
     "No people, or one receptionist far in the background, out of focus.", ''),
    ('page-billing-and-insurance', 'Billing & Insurance page header', '/billing-and-insurance/', 'Landscape 3:2 (1536×1024)',
     "A friendly patient coordinator at a modern front desk helping a patient, holding a plain blank card (no text) and a tablet, both smiling naturally in conversation.",
     PEOPLE_DEFAULT, ''),
    ('page-your-first-visit', 'Your First Visit page header', '/your-first-visit/', 'Landscape 3:2 (1536×1024)',
     "A clinician and a new patient sitting together in a bright consultation room, the clinician listening attentively and taking notes on a clipboard (no readable text).",
     PEOPLE_DEFAULT, ''),
    ('page-phase-of-relief', 'Phases of Care page header', '/phase-of-relief/', 'Landscape 3:2 (1536×1024)',
     "A patient doing a guided rehabilitation exercise with a resistance band in a bright clinic rehab area while a clinician encourages and supports the movement.",
     PEOPLE_DEFAULT, ''),
    ('social-share', 'Social share image', 'Shown when links are shared on Facebook, LinkedIn, iMessage, etc.', 'Landscape 3:2 (1536×1024) — crop to 1200×630 if you can',
     "A wide, bright, premium modern treatment room with a padded treatment table, warm wood, navy accents and large windows with soft Arizona daylight; inviting and calm.",
     "No people.", ''),
]


def prompt_text(title, scene, people, fmt, page_label):
    head = f'Create a photorealistic image for the "{title}" {page_label} of a premium, modern non-surgical spine, joint and pain clinic in Arizona.'
    return head + "\n\nSCENE: " + scene + "\n\n" + STYLE.format(format=fmt, people=people)


def write(path, content):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, 'w') as f:
        f.write(content)


def main():
    all_md = []
    rows = []
    for i, (slug, title, cat, scene, people, note) in enumerate(TREATMENTS, 1):
        fname = f'{slug}.jpg'
        p = prompt_text(title, scene, people or PEOPLE_DEFAULT, 'Landscape 3:2 (1536×1024)', 'treatment page')
        md = f"""# {i:02d}. {title}

- **Save the image as:** `{fname}`
- **Used on:** https://ahrons20.sg-host.com/service/{slug}/ (page header + treatment cards)
- **Category:** {CATS[cat]}
{('- **Note:** ' + note) if note else ''}

## Prompt (copy everything in the box into ChatGPT)

```
{p}
```
"""
        write(os.path.join(OUT, 'treatments', f'{i:02d}-{slug}.md'), md)
        all_md.append(md)
        rows.append(f'| {i:02d} | {title} | `{fname}` | [prompt](treatments/{i:02d}-{slug}.md) |')

    page_rows = []
    for slug, title, used, fmt, scene, people, note in PAGES:
        p = prompt_text(title, scene, people, fmt, 'section')
        md = f"""# {title}

- **Save the image as:** `{slug}.jpg`
- **Used on:** {used}
- **Size:** {fmt}
{('- **Note:** ' + note) if note else ''}

## Prompt (copy everything in the box into ChatGPT)

```
{p}
```
"""
        write(os.path.join(OUT, 'pages', f'{slug}.md'), md)
        all_md.append(md)
        page_rows.append(f'| {title} | `{slug}.jpg` | [prompt](pages/{slug}.md) |')

    readme = f"""# Image prompts for ChatGPT

One prompt per treatment page plus the homepage and page headers. Every prompt uses the same photographic style, so the whole site looks like a single, consistent photo shoot.

## How to use

1. Open ChatGPT, start a **new chat** and paste **one** prompt. Each prompt is self-contained.
2. If the result has any text, logos or labels, reply: *"Regenerate exactly the same scene without any text, letters, labels or logos."*
3. If people look artificial, reply: *"More natural and candid, realistic skin texture, softer daylight."*
4. Download the image and **rename it to the exact file name shown** (e.g. `shockwave-therapy.jpg`). PNG or WebP are fine too; the name before the extension is what matters.
5. Upload all of them at once in **Dashboard → Media Library** (drag & drop). The site resizes them and makes WebP versions automatically.
6. Click **Auto-assign images** at the top of the Media Library, check the preview and press **Assign images**. Every image is attached to its page automatically, and alt text is filled in for SEO.

Re-uploading a file with the same name later and running Auto-assign with **"Replace images that are already set"** swaps the old image for the new one.

## Important

- **Provider photos must be real photos of the actual providers.** Never use AI-generated faces for real doctors. Name them `provider-<slug>.jpg`, e.g. `provider-dr-andre-silano.jpg`, in portrait 4:5 with the face in the upper third.
- **Office photos** should be real photos of the Gilbert and Tempe offices: `location-gilbert.jpg`, `location-tempe.jpg`.
- **Logo:** upload the official file as `logo.png` (and `logo-light.png` for the dark footer, `favicon.png`).
- AI images are illustrative. Avoid using them to show specific outcomes, real equipment brands or real staff.

## Treatment pages ({len(TREATMENTS)})

| # | Treatment | File name | Prompt |
|---|---|---|---|
""" + "\n".join(rows) + f"""

## Homepage & page headers ({len(PAGES)})

| Image | File name | Prompt |
|---|---|---|
""" + "\n".join(page_rows) + "\n\nAll prompts in one file: [ALL-PROMPTS.md](ALL-PROMPTS.md)\n"
    write(os.path.join(OUT, 'README.md'), readme)
    write(os.path.join(OUT, 'ALL-PROMPTS.md'), "# All image prompts\n\nSee README.md for instructions and file naming.\n\n---\n\n" + "\n---\n\n".join(all_md))
    print(f'Wrote {len(TREATMENTS)} treatment prompts and {len(PAGES)} page prompts to {OUT}')


if __name__ == '__main__':
    main()
