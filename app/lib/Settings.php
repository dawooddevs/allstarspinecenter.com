<?php
/**
 * Key/value site settings with sensible defaults. Everything here is editable
 * from Dashboard → Settings.
 */
final class Settings
{
    private static ?array $cache = null;

    public static function defaults(): array
    {
        return [
            // General
            'site_name' => 'All Star Health Spine & Joint Care',
            'site_short_name' => 'All Star Health',
            'tagline' => 'Advanced Non-Surgical Spine, Joint & Pain Care',
            'brand_description' => 'Integrated non-surgical spine, joint, pain, chiropractic and rehabilitation care serving Gilbert and Tempe, Arizona.',
            'phone' => '844-844-4755',
            'sms_phone' => '844-844-4755',
            'email' => '',
            'notify_email' => '',
            'communities' => 'Gilbert, Tempe, Chandler, Mesa',
            'founded_year' => '1997',

            // Branding
            'logo' => '',
            'logo_light' => '',
            'favicon' => '',
            'color_primary' => '#0c2d5e',
            'color_accent' => '#e23744',
            'color_highlight' => '#2f7cf6',

            // Homepage
            'hero_line1' => 'Live With Less Pain.',
            'hero_line2' => 'Move With More Freedom.',
            'hero_copy' => 'Advanced non-surgical spine, joint and pain care from an integrated team of medical providers, chiropractors and rehabilitation professionals in Gilbert and Tempe, Arizona.',
            'hero_image' => '',
            'hero_badges' => "Same-Day Appointments\nMost Major Insurance Accepted\nGilbert & Tempe Locations\nNon-Surgical Treatment Options",
            'about_image' => '',
            'stats' => json_encode([
                ['value' => 28, 'suffix' => '+', 'label' => 'Years Serving the Community'],
                ['value' => 150, 'suffix' => '+', 'label' => 'Years Combined Clinical Experience'],
                ['value' => 2, 'suffix' => '', 'label' => 'Arizona Locations'],
            ]),
            'featured_services' => 'regenerative-medicine,knee-pain-relief,shockwave-therapy,spinal-decompression-therapy,trigger-point-and-joint-injections,ultrasound-guided-injections-and-diagnostics,pens-dry-needling-treatment,chiropractic-therapy,car-accident-injury-treatment,sports-injuries-and-physical-fitness',

            // Integrations
            'ghl_appointment_embed' => '',
            'ghl_contact_embed' => '',
            'ghl_benefits_embed' => '',
            'ghl_webhook_url' => '',
            'chat_widget' => '',
            'head_scripts' => '',
            'body_scripts' => '',
            'ga_id' => '',

            // Patient forms (media library URLs)
            'form_new_patient_en' => '',
            'form_new_patient_es' => '',
            'form_accident_en' => '',
            'form_accident_es' => '',
            'form_pain_questionnaire' => '',

            // Videos (empty = match the old site's file name in the Media Library)
            'video_patient_1' => '',
            'video_patient_2' => '',
            'video_patient_3' => '',
            'video_silano' => '',

            // Social
            'social_facebook' => '',
            'social_x' => '',
            'social_instagram' => '',

            // SEO
            'seo_title_suffix' => ' | All Star Health',
            'seo_default_description' => 'Advanced non-surgical spine, joint and pain care in Gilbert and Tempe, AZ. Chiropractic, regenerative medicine, injections, rehab, injury care and more. Call 844-844-4755.',
            'seo_og_image' => '',
            'seo_noindex' => '1',
            'cookie_notice' => '0',

            // Appointment CTA
            'cta_headline' => 'Ready to Take the Next Step?',
            'cta_copy' => 'Whether you\'re dealing with a recent injury or persistent pain, our team can help you determine the right place to start.',
            'cta_small_print' => 'Requested times must be confirmed by the office; requests may be held for 48 hours while confirmation is attempted.',
        ];
    }

    private static function load(): array
    {
        if (self::$cache === null) {
            self::$cache = [];
            if (DB::connected()) {
                try {
                    foreach (DB::all('SELECT k, v FROM settings') as $r) {
                        self::$cache[$r['k']] = $r['v'];
                    }
                } catch (Throwable $e) {
                    // table may not exist yet during install
                }
            }
        }
        return self::$cache;
    }

    public static function get(string $key, $default = null)
    {
        $all = self::load();
        if (array_key_exists($key, $all) && $all[$key] !== null) {
            return $all[$key];
        }
        $d = self::defaults();
        return $d[$key] ?? $default;
    }

    public static function all(): array
    {
        return array_merge(self::defaults(), array_filter(self::load(), fn($v) => $v !== null));
    }

    public static function set(string $key, $value): void
    {
        $value = is_array($value) ? json_encode($value) : (string)$value;
        if (DB::val('SELECT COUNT(*) FROM settings WHERE k = ?', [$key])) {
            DB::update('settings', ['v' => $value], 'k = ?', [$key]);
        } else {
            DB::insert('settings', ['k' => $key, 'v' => $value]);
        }
        self::$cache = null;
    }

    public static function flush(): void
    {
        self::$cache = null;
    }
}
