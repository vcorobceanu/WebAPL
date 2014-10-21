<article class="doc">
    <p class="ttl"><img src="<?= res('assets/img/doc.png'); ?>"><a href="<?= Language::url('topage/acteList'); ?>">Toate actele locale</a></p>
    <div class="hr"></div>
    <table>
        <tbody>
            <?php foreach ($acte as $act) { ?>
                <tr>
                    <td><?= $act->doc_nr; ?></td><td><a target="_blank" href="<?= url($act->path); ?>"><?= $act->title; ?></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="javascript:;" class="more"></a>
    <div class="clearfix10"></div>
</article>