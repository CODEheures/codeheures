/**
 * Created by Papoun on 13/10/2015.
 */
$(function() {

    //parametre application
    var $navbarMenu = $('.navbar-menu');
    var $hamburger = $('.hamburger');
    var $alerts = $('.alert');
    var $menu_links = $('.navbar-menu a');
    var $tableaux = $('section#user div.purchase table.purchase-table, section#user div.quotation table.quotation-table');

    function setHeightHeader() {
        var $height = $(window).height();
        $('body > header').css({'height': $height})
    }

    function shrinkNavBar($window_scrollTop) {
        if($window_scrollTop >= 15) {
            $('.navbar').removeClass('full').addClass('shrink');
        } else {
            $('.navbar').removeClass('shrink').addClass('full');
        }
    }

    function setOpacityHeader($window_scrollTop) {
        var $opacity = 1- $window_scrollTop/250;
        $('.header-content').css({
            'opacity':$opacity,
            'margin-top': $window_scrollTop
        });
    }

    function defAncre($name) {

        var $obj = {};
        var $jQobj = $('#'+$name);

        //console.log($jQobj);
        if($jQobj.length == 0){
            return null;
        }

        $obj['name'] = $name;
        $obj['top'] = Math.abs($jQobj.offset().top / $(document).height());

        return $obj;
    }

    //Gestion du tunnel page acceuil
    var $tunnel = $('.tunnel');
    var $sections = $tunnel.children('section');
    $sections.each(function (index) {
        if(index > 0) {
            $(this).hide();
        }
    });

    $('a[data-from]').click(function (e) {
        e.preventDefault();

        var $from = $sections.eq($(this).data('from'));
        var $to = $sections.eq($(this).data('to'));

        var $xScroll = ($(this).data('from')-$(this).data('to'))*100;

        $('html,body').animate({scrollTop: $from.offset().top}, function () {
            if($xScroll < 0) {
                $to.slideDown({
                    start: function () {
                        $from.animate({'margin-left': $xScroll+'%'}, 800, function () {
                            $from.slideUp(function () {
                                $from.css({'margin-left': '0'});
                            });
                        });
                    }
                });
            } else {
                $to.css({'margin-left': (-$xScroll)+'%'});
                $to.slideDown({
                    start: function () {
                        $to.animate({'margin-left': 0}, 800, 'swing', function () {
                            $from.slideUp(800);
                        });
                    }
                });
            }
        });
    });

    setHeightHeader();
    $(window).resize(function() {
        setHeightHeader();
    });

    $(window).scroll(function() {

        var $total_scroll = $(document).height()-$(window).height();
        var $window_scrollTop = $(window).scrollTop();
        var $rate_scroll = $window_scrollTop/$total_scroll;

        //adaptation de la navbar
        shrinkNavBar($window_scrollTop);

        //adaptation du fond
        setOpacityHeader($window_scrollTop);

        //definition des ancres  mettre dans l'ordre de hauteur
        var $name_ancres = ['accueil','prestations', 'contact'];
        var $ancres = [];
        for(var $key in $name_ancres){
            $def_ancre = defAncre($name_ancres[$key]);
            $def_ancre != null ? $ancres.push($def_ancre):null;
        }

        //Recherche de l'ancre la plus proche du scroll
        var $memo_key = '';
        for(var $key in $ancres) {
            if ($rate_scroll >= $ancres[$key]['top']) {
                $memo_key = $key
            }
        }

        //Action sur la clé la plus proche du scroll
        $('.navbar-menu a').each(function(){
            if($memo_key != '' && $(this).attr('href').indexOf('#'+$ancres[$memo_key]['name']) > -1 && !$(this).hasClass('active')){
                console.log($ancres[$memo_key]['name']);
                if($ancres[$memo_key]['name'] != 'contact') {
                    $(this).trigger('click');
                } else if ($ancres[$memo_key]['name'] == 'contact' && $total_scroll == $window_scrollTop) {
                    $(this).trigger('click');
                } else {
                    $(this).prev().trigger('click');
                }
            }
        });

        //animation des descriptions des cartes
        var $card = $('.card');

        $card.each(function(){

            if($(this).offset().top - $(window).height() + $(this).height() - $window_scrollTop <= 0){
                $(this).children('.card_description').css({'opacity': '1'}).addClass('animated slideInRight')
            }

            if($(this).offset().top - $(window).height() - $window_scrollTop >= 0){
                $(this).children('.card_description').css({'opacity': '0'}).removeClass('animated slideInRight')
            }
        });
    });

    //Gestion du menu principal
    $menu_links.on('click', function(e){
        $menu_links.each(function() {
            $(this).attr('aria-selected', 'false');
        });
        $(this).attr('aria-selected', 'true');
    });

    //Menu hamburger
    $hamburger.on('click', function(e){
        e.preventDefault();
        if($navbarMenu.css('display')==='flex'){
            $navbarMenu.css('display', '');
        } else {
            $navbarMenu.css('display','flex');
        }
    });

    //Fermeture des alerts
    $alerts.each(function(){
        $(this).find('.close_btn').on('click', function(){
            $(this).parent().parent().slideUp(500, function() {
                $(this).remove();
            });
        })
    });

    //Animation des tableaux de consommation
    $tableaux.each(function(){
        $(this).children('tfoot').on('click', function() {
           $(this).parent().children('tbody').children('tr').each(function(){
              $(this).fadeToggle(600, function(){
                  setHeightHeader();
              });
           });
           $(this).find('i').toggleClass('ion-chevron-down');
           $(this).find('i').toggleClass('ion-chevron-up');
        });
    });

    //Assistance au remplissage consommation client
    //En cas de modif du champ prestation standard AJAX pour récup valeur et mise à jour auto du pointage
    $('[data-assist="assist1"]').change(function () {
        //AJAX pour recup valeurs prestation standard
        if($('[data-assist="assist1"]').val() != 0) {
            $.ajax('/admin/prestation/' + $('[data-assist="assist1"]').val())
                .done(function (data) {
                    var $assist = $('[data-isAssistBy="assist1"]');
                    $assist.attr('max', data.duration);
                    $assist.val(data.duration);
                    if($assist.parent().is('span.input--fumi')){
                        $assist.parent().addClass('input--filled');
                        $assist.attr('data-placeholder', 'maxi: ' + data.duration);
                    }
                });
        } else {
            var $assist = $('[data-isAssistBy="assist1"]');
            $assist.attr('data-placeholder', '2.4');
            $assist.attr('max', '');
        }
    });




    /*****************************************************************************************************/
    /*                                              SELECT 2                                             */
    /*****************************************************************************************************/
    $('select[multiple]').select2();


    /*****************************************************************************************************/
    /*                                              INPUT FUMI                                           */
    /*****************************************************************************************************/
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

    [].slice.call( document.querySelectorAll( 'select.input__field' ) ).forEach( function( inputEl ) {
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