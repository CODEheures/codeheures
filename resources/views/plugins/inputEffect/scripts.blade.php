<script type="text/javascript">
    $(document).ready(function() {
        // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
        if (!String.prototype.trim) {
            (function() {
                // Make sure we trim BOM and NBSP
                var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function() {
                    return this.replace(rtrim, '');
                };
            })();
        }

        [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
            // in case the input is already filled..
            if( inputEl.value.trim() !== '' ) {
                $(inputEl).parent().addClass('input--filled');
            }

            $(inputEl).attr('data-placeholder',$(inputEl).attr('placeholder'));
            $(inputEl).removeAttr('placeholder');

            // events:
            inputEl.addEventListener( 'focus', onInputFocus );
            inputEl.addEventListener( 'blur', onInputBlur );
        } );

        [].slice.call( document.querySelectorAll( 'textarea.input__field' ) ).forEach( function( inputEl ) {
            // in case the input is already filled..
            if( inputEl.value.trim() !== '' ) {
                $(inputEl).parent().addClass('input--filled');
            }

            $(inputEl).attr('data-placeholder',$(inputEl).attr('placeholder'));
            $(inputEl).removeAttr('placeholder');

            // events:
            inputEl.addEventListener( 'focus', onInputFocus );
            inputEl.addEventListener( 'blur', onInputBlur );
        } );

        function onInputFocus( ev ) {
            $elem = ev.target;
            $($elem).attr('placeholder',$($elem).attr('data-placeholder'));
            $($elem).parent().addClass('input--filled');
        }

        function onInputBlur( ev ) {
            $elem = ev.target;
            if( $elem.value.trim() === '' ) {
                $($elem).attr('data-placeholder',$($elem).attr('placeholder'));
                $($elem).removeAttr('placeholder');
                $($elem).parent().removeClass('input--filled');
            }
        }
    });
</script>