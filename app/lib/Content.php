<?php
/**
 * Read-side content repository used by the public templates.
 */
final class Content
{
    public const CATEGORIES = [
        'medical' => ['label' => 'Medical Treatments', 'short' => 'Medical', 'icon' => 'stethoscope', 'blurb' => 'Injections, regenerative medicine, decompression and advanced in-office procedures.'],
        'soft-tissue' => ['label' => 'Soft Tissue Management', 'short' => 'Soft Tissue', 'icon' => 'waves', 'blurb' => 'Hands-on and instrument-assisted therapies for muscles and fascia.'],
        'injury' => ['label' => 'Injury & Accident Care', 'short' => 'Injury Care', 'icon' => 'car', 'blurb' => 'Evaluation and care after auto, work and sports injuries.'],
        'chiropractic' => ['label' => 'Chiropractic Care', 'short' => 'Chiropractic', 'icon' => 'spine', 'blurb' => 'Spinal and joint adjustments to support alignment, motion and function.'],
        'allergy' => ['label' => 'Allergy Treatments', 'short' => 'Allergy', 'icon' => 'flower', 'blurb' => 'Testing and immunotherapy for environmental and food allergies.'],
        'medical-foods' => ['label' => 'Medical Foods', 'short' => 'Medical Foods', 'icon' => 'pill', 'blurb' => 'Physician-supervised medical foods used as part of a care plan.'],
    ];

    public const PROVIDER_TYPES = [
        'chiropractor' => 'Chiropractors',
        'family_medicine' => 'Family Medicine',
        'physician_assistant' => 'Physician Assistants',
        'other' => 'Clinical Team',
    ];

    public const BODY_AREAS = [
        'neck' => 'Neck', 'shoulder' => 'Shoulder', 'back' => 'Back', 'hip' => 'Hip', 'knee' => 'Knee',
        'elbow' => 'Elbow', 'wrist-hand' => 'Wrist / Hand', 'leg' => 'Leg', 'ankle-foot' => 'Ankle / Foot', 'joint' => 'General Joint Pain',
    ];

    private static array $cache = [];

    public static function services(bool $publishedOnly = true): array
    {
        $key = 'services' . (int)$publishedOnly;
        if (!isset(self::$cache[$key])) {
            $sql = 'SELECT * FROM services' . ($publishedOnly ? " WHERE status = 'published'" : '') . ' ORDER BY sort_order, title';
            self::$cache[$key] = DB::all($sql);
        }
        return self::$cache[$key];
    }

    public static function servicesByCategory(): array
    {
        $out = array_fill_keys(array_keys(self::CATEGORIES), []);
        foreach (self::services() as $s) {
            $out[$s['category']][] = $s;
        }
        return $out;
    }

    public static function service(string $slug): ?array
    {
        return DB::one("SELECT * FROM services WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function servicesBySlugs(array $slugs): array
    {
        $by = [];
        foreach (self::services() as $s) {
            $by[$s['slug']] = $s;
        }
        $out = [];
        foreach ($slugs as $slug) {
            if (isset($by[$slug])) {
                $out[] = $by[$slug];
            }
        }
        return $out;
    }

    public static function providers(): array
    {
        if (!isset(self::$cache['providers'])) {
            self::$cache['providers'] = DB::all("SELECT * FROM providers WHERE status = 'published' ORDER BY sort_order, name");
        }
        return self::$cache['providers'];
    }

    public static function provider(string $slug): ?array
    {
        return DB::one("SELECT * FROM providers WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function page(string $slug): ?array
    {
        return DB::one("SELECT * FROM pages WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function locations(): array
    {
        if (!isset(self::$cache['locations'])) {
            self::$cache['locations'] = DB::all("SELECT * FROM locations WHERE status = 'published' ORDER BY sort_order, name");
        }
        return self::$cache['locations'];
    }

    public static function testimonials(bool $featuredOnly = false): array
    {
        $sql = "SELECT * FROM testimonials WHERE status = 'published' AND content IS NOT NULL AND content <> ''" . ($featuredOnly ? ' AND featured = 1' : '') . ' ORDER BY sort_order, id';
        return DB::all($sql);
    }

    public static function faqs(string $group): array
    {
        return DB::all("SELECT * FROM faqs WHERE grp = ? AND status = 'published' ORDER BY sort_order, id", [$group]);
    }

    public static function serviceUrl(array $s): string
    {
        return url('service/' . $s['slug'] . '/');
    }

    public static function providerUrl(array $p): string
    {
        return url('doctor/' . $p['slug'] . '/');
    }

    public static function categoryLabel(string $cat): string
    {
        return self::CATEGORIES[$cat]['label'] ?? ucfirst($cat);
    }

    public static function serviceIcon(array $s): string
    {
        return $s['icon'] ?: (self::CATEGORIES[$s['category']]['icon'] ?? 'activity');
    }

    /** Related services: explicit list first, then same-category siblings. */
    public static function related(array $s, int $limit = 4): array
    {
        $out = self::servicesBySlugs(csv_list($s['related'] ?? ''));
        if (count($out) < $limit) {
            foreach (self::services() as $o) {
                if ($o['category'] === $s['category'] && $o['slug'] !== $s['slug'] && !in_array($o, $out, true)) {
                    $out[] = $o;
                }
                if (count($out) >= $limit) {
                    break;
                }
            }
        }
        return array_slice(array_values(array_filter($out, fn($o) => $o['slug'] !== $s['slug'])), 0, $limit);
    }

    public static function bodyAreaMap(): array
    {
        // Group matches per area and category, then interleave categories so
        // each area shows a balanced mix (max 8) rather than one category.
        $buckets = array_fill_keys(array_keys(self::BODY_AREAS), []);
        foreach (self::services() as $s) {
            foreach (csv_list($s['body_areas']) as $a) {
                if (isset($buckets[$a])) {
                    $buckets[$a][$s['category']][] = [
                        'title' => $s['menu_label'] ?: $s['title'],
                        'url' => self::serviceUrl($s),
                        'category' => self::CATEGORIES[$s['category']]['short'] ?? '',
                    ];
                }
            }
        }
        $map = [];
        foreach ($buckets as $area => $cats) {
            $map[$area] = [];
            while (count($map[$area]) < 8 && $cats) {
                foreach ($cats as $c => &$items) {
                    if ($items && count($map[$area]) < 8) {
                        $map[$area][] = array_shift($items);
                    }
                    if (!$items) {
                        unset($cats[$c]);
                    }
                }
                unset($items);
            }
        }
        return $map;
    }

    /**
     * Downloadable PDFs shown on /make-appointment/ (same groups and files as the old site).
     * Each file is found in the Media Library by its original file name, so uploading a PDF
     * with the same name links it automatically. A Patient Forms setting overrides the match;
     * until a file is uploaded, the link points to the copy on the old website.
     */
    public const FORM_GROUPS = [
        'patient' => [
            'title' => 'Patient Forms', 'icon' => 'clipboard',
            'text' => 'New patient paperwork. Complete it before your first visit to save time at check-in.',
            'items' => [
                ['label' => 'Patient Forms — English', 'file' => 'Updated-1-13-26-All-Star-Health-New-Patient-Form-English.pdf', 'old' => '2026/01', 'setting' => 'form_new_patient_en'],
                ['label' => 'Patient Forms — Spanish', 'file' => 'Updated-1-13-26-All-Star-Health-New-Patient-Form-Spanish.pdf', 'old' => '2026/01', 'setting' => 'form_new_patient_es'],
            ],
        ],
        'accident' => [
            'title' => 'Accident Forms', 'icon' => 'car',
            'text' => 'New patient paperwork with accident information, for car accident and injury visits.',
            'items' => [
                ['label' => 'Accident Forms — English', 'file' => 'Updated-1-13-26-All-Star-Health-New-Patient-Form-with-Accident-info-English.pdf', 'old' => '2026/01', 'setting' => 'form_accident_en'],
                ['label' => 'Accident Forms — Spanish', 'file' => 'Updated-1-13-26-All-Star-Health-New-Patient-Form-Accident-Spanish.pdf', 'old' => '2026/01', 'setting' => 'form_accident_es'],
            ],
        ],
        'questionnaires' => [
            'title' => 'Pain Treatment Questionnaires', 'icon' => 'file-text',
            'text' => 'Download the questionnaire for the area you are being treated for and bring it to your visit.',
            'items' => [
                ['label' => 'Knee & Hip Osteoarthritis Assessment (WOMAC)', 'file' => 'WOMAC.pdf', 'old' => '2025/04'],
                ['label' => 'Low Back Pain Disability Questionnaire', 'file' => 'Modified-Oswestry-Low-Back-Pain-Disability-Questionnaire.pdf', 'old' => '2025/04'],
                ['label' => 'Neck Pain & Function Questionnaire', 'file' => 'Neck-Disabilty-Index.pdf', 'old' => '2025/04'],
                ['label' => 'Shoulder Pain & Disability Index (SPADI)', 'file' => 'Shoulder-Pain-and-Disability-Index-SPADI.pdf', 'old' => '2025/04'],
                ['label' => 'Hip Function Assessment (HOS)', 'file' => 'Hip-Outcome-Score-HOS.pdf', 'old' => '2025/04'],
                ['label' => 'Foot & Ankle Function Assessment', 'file' => 'Foot-and-Ankle-Ability-Measure.pdf', 'old' => '2025/04'],
                ['label' => 'Tennis Elbow Self-Evaluation', 'file' => 'Patient-Rated-Tennis-Elbow-Evaluation.pdf', 'old' => '2025/04'],
                ['label' => 'Wrist Pain & Function Questionnaire', 'file' => 'Patient-related-wrist-evaluation.pdf', 'old' => '2025/04'],
                ['label' => 'Carpal Tunnel Questionnaire', 'file' => 'BCTQ.pdf', 'old' => '2026/08'],
                ['label' => 'Plantar Fasciitis Pain/Disability Scale Questionnaire', 'file' => 'plantar-fasciitis-pain-disability-scale-questionnaire.pdf', 'old' => '2025/05'],
            ],
        ],
    ];

    private const OLD_UPLOADS = 'https://allstarspinecenter.com/wp-content/uploads/';

    private static ?array $formGroups = null;

    /** FORM_GROUPS with each item resolved to a url and its source: setting, library or old-site. */
    public static function formGroups(): array
    {
        if (self::$formGroups !== null) {
            return self::$formGroups;
        }
        // Match on the file name, ignoring case, punctuation and copy suffixes such as "WOMAC (1).pdf".
        // Newer uploads win when the same form was uploaded twice.
        $key = fn(string $name): string => preg_replace('/-\d+$/', '', substr(slugify(pathinfo($name, PATHINFO_FILENAME)), 0, 60));
        $library = [];
        foreach (DB::all("SELECT path, original_name FROM media WHERE kind = 'document' ORDER BY id") as $m) {
            $library[$key((string)$m['original_name'])] = $m['path'];
            $library[$key(basename((string)$m['path']))] = $m['path'];
        }
        $groups = [];
        foreach (self::FORM_GROUPS as $gk => $g) {
            foreach ($g['items'] as &$f) {
                $set = isset($f['setting']) ? trim((string)setting($f['setting'], '')) : '';
                $path = $library[$key($f['file'])] ?? null;
                if ($set !== '') {
                    [$f['url'], $f['source']] = [media_url($set), 'setting'];
                } elseif ($path) {
                    [$f['url'], $f['source']] = [media_url($path), 'library'];
                } else {
                    [$f['url'], $f['source']] = [self::OLD_UPLOADS . $f['old'] . '/' . $f['file'], 'old-site'];
                }
            }
            unset($f);
            $groups[$gk] = $g;
        }
        return self::$formGroups = $groups;
    }

    /** Short list for menus and sidebars: the four patient/accident PDFs plus a link to the questionnaires. */
    public static function patientForms(): array
    {
        $g = self::formGroups();
        $out = [];
        foreach (array_merge($g['patient']['items'], $g['accident']['items']) as $f) {
            $out[] = ['label' => $f['label'], 'url' => $f['url'], 'available' => true, 'download' => true, 'source' => $f['source']];
        }
        $out[] = ['label' => 'Pain Treatment Questionnaires', 'url' => url('make-appointment/#pain-questionnaires'), 'available' => true, 'download' => false, 'source' => 'page'];
        return $out;
    }

    public static function hours(array $loc): array
    {
        return json_list($loc['hours'] ?? '[]');
    }

    public static function mapsDirections(array $loc): string
    {
        if (!empty($loc['directions_url'])) {
            return $loc['directions_url'];
        }
        $q = $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
        return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($q);
    }

    public static function mapEmbed(array $loc): string
    {
        if (!empty($loc['map_embed'])) {
            if (preg_match('~src="([^"]+)"~', $loc['map_embed'], $m)) {
                return html_entity_decode($m[1]);
            }
            return $loc['map_embed'];
        }
        $q = $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
        return 'https://www.google.com/maps?q=' . rawurlencode('All Star Health, ' . $q) . '&output=embed';
    }

    public static function fullAddress(array $loc): string
    {
        return $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
    }
}
