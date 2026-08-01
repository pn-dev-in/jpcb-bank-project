<?php
/* ── Shared helpers ── available to every sub-view via include scope ─────── */
$mediaUrl = static function (?string $path): string {
    $path = trim((string) $path);
    if ($path === '') return '';
    return preg_match('~^https?://~i', $path) ? $path : base_url($path);
};
$plainText = static function (?string $value): string {
    return trim(preg_replace('/\s+/', ' ', strip_tags((string) $value)));
};
$dateLabel = static function (?string $date): string {
    if (empty($date) || strtotime($date) === false) return '';
    return date('d M Y', strtotime($date));
};
$initials = static function (string $name): string {
    $clean = preg_replace('/^(Mr\.|Mrs\.|Ms\.|Dr\.|Prof\.|CA\s|CS\s)/i', '', $name);
    $words = preg_split('/\s+/', trim($clean));
    return strtoupper(substr($words[0] ?? 'X', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
};

/* ── Gallery filter (needed by gallery sub-view) ─────────────────────────── */
$aboutContent          = $aboutContent ?? [];
$galleryCategorySlug   = strtolower((string) ($query['category'] ?? 'all'));
$filteredGalleryItems  = $galleryItems ?? [];
if ($galleryCategorySlug !== 'all') {
    $filteredGalleryItems = array_values(array_filter(
        $galleryItems ?? [],
        static fn($item) => strtolower((string)($item['category_slug'] ?? '')) === $galleryCategorySlug
    ));
}

/* ── Route to the correct sub-view ──────────────────────────────────────── */
$_subView = APPPATH . 'Views/pages/content/about/' . ($pageKey ?? 'index') . '.php';
if (file_exists($_subView)) {
    include $_subView;
} else {
    echo '<div class="container-bank section-padding"><p style="color:hsl(var(--muted-foreground));">Page not found.</p></div>';
}
