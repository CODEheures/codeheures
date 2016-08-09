<script type="text/javascript" src="{{ asset('js/jquery.countdown.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.clock-down').countdown({
            date: "January 2, 2017 09:00:00",
            onEnd: function () {
                $('.clock-down').parent().slideToggle();
            },
            render: function(data) {
                var el = $(this.el);
                el.empty()
                        .append("<div class='part'>" + this.leadingZeros(data.days, 3) + " <span>jours</span></div>")
                        .append("<div class='part'>" + this.leadingZeros(data.hours, 2) + " <span>hrs</span></div>")
                        .append("<div class='part'>" + this.leadingZeros(data.min, 2) + " <span>min</span></div>")
                        .append("<div class='part'>" + this.leadingZeros(data.sec, 2) + " <span>sec</span></div>");
            }
        });
    });
</script>