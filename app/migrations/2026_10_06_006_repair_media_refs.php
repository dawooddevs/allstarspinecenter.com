<?php
/**
 * Repairs image references after files were deleted or re-uploaded in the Media Library:
 * fields pointing at deleted files (or at an older copy of a re-uploaded file) are re-linked to
 * the matching upload by file name; any that still point at a missing file are cleared.
 */
return function (): array {
    $res = Media::autoAssign(true, false, true);
    $log = [];
    foreach ($res['matches'] as $m) {
        if ($m['status'] === 'assigned') {
            $log[] = "{$m['kind']} \"{$m['label']}\" → {$m['file']}";
        }
    }
    foreach (Media::clearBroken() as $c) {
        $log[] = "cleared missing file: {$c}";
    }
    return $log ?: ['nothing to repair'];
};
