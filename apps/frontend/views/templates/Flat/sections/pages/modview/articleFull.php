<p class="det_news"><?= $post->title; ?></p>
<p class="p_data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?>    </p>
<div class="hr_dbl"></div>
<div class="u_a">
    <?php if ($post->cover) { ?>
        <img alt="<?= $post->title; ?>" title="<?= $post->title; ?>" src="<?= url($post->cover['path']); ?>">
    <?php } ?>
</div>
<div class='conten'>
    <?php if ($post->show_pcomment) { ?>
        <div class='cont live_comment' data-pid="news<?= $post->id; ?>">
            <?= Core\APL\Shortcodes::execute($post->text); ?>
        </div>
    <?php } else { ?>
        <div class='cont'><?= Core\APL\Shortcodes::execute($post->text); ?></div>
    <?php } ?>

    <?php if ($post->have_socials) { ?>
        <?= View::make('sections.elements.socials'); ?>
    <?php } ?>

    <div class="hr_grey"></div>

    <?php if ($post->have_comments) { ?>
        <?= View::make('sections.elements.comments'); ?>
    <?php } ?>
</div>
