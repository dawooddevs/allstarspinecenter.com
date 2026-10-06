<?php
/** Removes four homepage FAQs the client no longer wants shown. */
return function (): array {
    $log = [];
    foreach (['Are your treatments non-surgical?', 'Can I text the office?', 'How do appointment requests work?', 'Where are your offices?'] as $q) {
        $n = DB::delete('faqs', "grp = 'home' AND question = ?", [$q]);
        $log[] = "{$q}: " . ($n ? 'removed' : 'not found');
    }
    return $log;
};
