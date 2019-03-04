<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://madg.com
 * @since      1.0.0
 *
 * @package    Mg_Debug
 * @subpackage Mg_Debug/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1>MG Debug</h1>

    <p><button class="button-secondary" data-clear-logs>Clear all logs</button></p>

<?php foreach( $logs as $log ): ?>
    
    <div class="mg-debug-card card">
        <div class="card-header">
            <p>
                <strong><?= sprintf( '[%s]', $log['date'] ) ?></strong>
            </p>

            <p class="card-actions">
                <a href="<?= $log['url'] ?>" target="_blank">New Window <span aria-hidden="true" class="dashicons dashicons-external"></span></a> |
                <a href="" class="danger" data-delete-log="<?= $log['filename'] ?>">Delete <span aria-hidden="true" class="dashicons dashicons-trash"></span></a>
            </p>
        </div>

        <div class="mg-debug-frame">
            <iframe src="<?= $log['url'] ?>" frameborder="0"></iframe>
        </div>
    </div>

<?php endforeach; ?>

</div>