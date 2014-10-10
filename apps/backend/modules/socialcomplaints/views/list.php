<script>
    var pages_json = <?= $pagesJson; ?>;
    var pages_string = "<?= $pagesString; ?>";

    var scomp_options = {
        url: '<?= url('socialcomplaints/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('page-4'); ?>', '<?= varlang('username-2'); ?>', '<?= varlang('email-8'); ?>', '<?= varlang('address-1'); ?>', '<?= varlang('title-8'); ?>', '<?= varlang('text-3'); ?>', '<?= varlang('response'); ?>', '<?= varlang('date-10'); ?>', '<?= varlang('private'); ?>', '<?= varlang('enabled-8'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'post_id', index: 'post_id', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: pages_string}, formatter: function(value) {
                    return pages_json[value];
                }},
            {name: 'username', index: 'username', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'email', index: 'email', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'address', index: 'address', height: 50, resizable: true, align: "left", editable: true, hidden: true, editrules: {edithidden: true}, edittype: "text"},
            {name: 'title', index: 'title', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'text', index: 'text', height: 50, resizable: true, align: "left", editable: true, hidden: true, editrules: {edithidden: true}, edittype: "textarea"},
            {name: 'response', index: 'response', height: 50, resizable: true, align: "left", editable: true, hidden: true, editrules: {edithidden: true}, edittype: "textarea"},
            {name: 'date_created', index: 'date_created', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'is_private', index: 'is_private', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Public;1:Private'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-info">Private</span>' : '<span class="label label-info">Public</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }},
            {name: 'enabled', index: 'enabled', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }},
        ],
        rowNum: 30,
        multiselect: true,
        rowList: [30, 50, 100],
        pager: '',
        altRows: true,
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        editurl: '<?= url('socialcomplaints/edititem') ?>',
        ondblClickRow: function(rowid) {
            jQuery(this).jqGrid('editGridRow', rowid, {
                recreateForm: true,
                closeAfterEdit: true,
                closeOnEscape: true,
                reloadAfterSubmit: false
            });
        },
        loadComplete: function() {
            //jQuery(this).jqGrid('hideCol','response');
        },
        onSelectRow: function() {
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'scomp_options'); ?>