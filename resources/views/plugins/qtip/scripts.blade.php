<script type="text/javascript" src="{{ asset('js/qtip2.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('a[title]').qtip({
            position: {
                my: 'top center',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-tipsy'
            }
        });
    });
</script>