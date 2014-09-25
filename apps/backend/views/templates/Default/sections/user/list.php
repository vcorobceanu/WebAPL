<script>
    var users_options = {
        url: '<?= url('user/lists') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Username', 'Email'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'username', index: 'username', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'email', index: 'email', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"}
        ],
        rowNum: 15,
        multiselect: true,
        rowList: [15, 30, 45],
        pager: '',
        altRows: true,
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        editurl: '',
        ondblClickRow: function() {
        },
        loadComplete: function() {
            $("#pager-user_list_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('user/view') ?>/'+rowid;
        }
    }
</script>

<?= View::make('sections/jqgrid/form')->with(array(
    'options' => 'users_options',
    'id' => 'user_list'
)); ?>