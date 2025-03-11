# Chart.js Offline Implementation

## Integration Instructions

To use the offline version of Chart.js in your views:

1. Replace CDN references with local assets:

```php
// Replace this:
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

// With this:
<script src="<?= base_url('assets/js/chartjs/chart.umd.min.js') ?>"></script>
```

2. For optional plugins, include them after Chart.js:

```php
<script src="<?= base_url('assets/js/chartjs/chartjs-plugin-datalabels.min.js') ?>"></script>
```

## Version Information

- Chart.js: v4.4.0
- Downloaded: $(date '+%Y-%m-%d')

## Updating Chart.js

To update Chart.js to a newer version, run the download script again with the updated version number.
