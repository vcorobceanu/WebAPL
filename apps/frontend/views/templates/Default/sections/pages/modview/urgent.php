<div class="emrg">
    <p class="ul_title">
        <span class="left">Telefon	</span>
        <span class="right">Serviciu</span>
    </p>
    <ul>
        <?php foreach ($feedPosts as $item) { ?>
            <li>
                <div class="left"><?= isset($item->phone_one) ? $item->phone_one : ''; ?></div>
                <div class="right"><?= $item['title']; ?></div>
            </li>
        <?php } ?>
    </ul>
</div>