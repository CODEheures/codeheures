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

    function animLogo() {
        var $logo = $('a.navbar-logo');
        $logo.removeClass("hidden");
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $logo.addClass("animated bounceInLeft").one(animationEnd, function() {
            setHeightHeader();
        });
    }

    function defAncre($name) {

        var $obj = {};
        var $jQobj = $('#'+$name);

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

        $('html body').animate({scrollTop: $from.offset().top}, function () {
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


    //GLOBAL
    setHeightHeader();
    animLogo();
    if($hamburger.css('display') === 'block'){
        $navbarMenu.css('display', 'none');
    }
    $(window).resize(function() {
        if($hamburger.css('display') === 'none'){
            $navbarMenu.css('display', 'flex');
        } else {
            $navbarMenu.css('display', 'none');
        }
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
            $navbarMenu.css('display', 'none');
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
    var $durationRef = 0;
    $('[data-assist="assist1"]').change(function () {
        var $ratio = $('[data-assist="assist1b"]');
        if($ratio.val()=='') {
            $ratio.val(1);
            if($ratio.parent().is('span.input--fumi')){
                $ratio.parent().addClass('input--filled');
            }
        }
        //AJAX pour recup valeurs prestation standard
        if($(this).val() != 0) {
            $.ajax('/admin/prestation/' + $(this).val())
                .done(function (data) {
                    $durationRef = data.duration;
                    var $assist = $('[data-isAssistBy="assist1"]');
                    $assist.attr('max', Math.round($durationRef*$ratio.val()*100)/100);
                    $assist.val(Math.round($durationRef*$ratio.val()*100)/100);
                    if($assist.parent().is('span.input--fumi')){
                        $assist.parent().addClass('input--filled');
                        $assist.attr('data-placeholder', 'maxi: ' + Math.round($durationRef*$ratio.val()*100)/100);
                    }
                });
        } else {
            $durationRef = 0;
            var $assist = $('[data-isAssistBy="assist1"]');
            if($assist.parent().is('span.input--fumi')){
                $assist.parent().addClass('input--filled');
                $assist.attr('data-placeholder', '2.4h');
            }
            $assist.attr('max', '');
            $ratio.val('');
            if($ratio.parent().is('span.input--fumi')){
                $ratio.parent().addClass('input--filled');
            }
        }
    });

    $('[data-assist="assist1b"]').change(function () {
        var $ref = $('[data-assist="assist1"]');
        if ($ref.val() != 0) {
            var $assist = $('[data-isAssistBy="assist1"]');
            $assist.attr('max', Math.round($durationRef*$(this).val()*100)/100);
            $assist.val(Math.round($durationRef*$(this).val()*100)/100);
            if($assist.parent().is('span.input--fumi')){
                $assist.parent().addClass('input--filled');
                $assist.attr('data-placeholder', 'maxi: ' + Math.round($durationRef*$(this).val()*100)/100);
            }
        }
    });

    //Assistance au slider quota admin customer
    var $ranges = $('[data-assist="assist2"]');
    $ranges.mousedown(function () {
        var $range = $(this);
        var $assist = $(this).parent().children('[data-isAssistBy="assist2"]');
        var listener = function() {
            window.requestAnimationFrame(function() {
                $assist.html('Nouveau quota:' + $range.val());
            });
        };
        $range.mousemove(function () {
            listener();
        });
    });

    $ranges.mouseup(function () {
        var $range = $(this);
        $range.unbind("mousemove");

    });


    //Gestion CSS des choix d'achats
    var $labelsChoice = $('.body-price label');
    var $inputsChoice = $('.body-price input[type="radio"]');
    var $buttonChoice = $('.form-prices button[type="submit"]');

    function choiced(elem) {
        $labelsChoice.removeClass('btn-yellow2');
        $labelsChoice.addClass('btn-yellow2-invert');
        elem.parent().removeClass('btn-yellow2-invert');
        elem.parent().addClass('btn-yellow2');
        $buttonChoice.attr('aria-disabled', 'false');
        $buttonChoice.removeClass('btn-yellow2-invert');
        $buttonChoice.addClass('btn-yellow2');
    }

    //when back browser with checked memory
    $inputsChoice.each(function () {
        if($(this).prop('checked')){
            choiced($(this));
        }
    });

    $inputsChoice.click(function (e) {
        choiced($(this));
    });

    //Approuve des CGV
    var $approuve = $('#approuve');
    if($approuve.length) {
        var $payoutLink = $('.payout a');
        var $payoutRoute = $payoutLink.attr('href');
        var $payoutImg = $payoutLink.children('img');
        var $payoutImgSrcDisable = $payoutImg.attr('src');
        var $payoutImgSrcEnable = $payoutImgSrcDisable.split('_')[0] + '.' +  $payoutImgSrcDisable.split('.')[$payoutImgSrcDisable.split('.').length-1];
        $payoutLink.attr('href', '');
        $approuve.change(function (e) {
            if($(this).prop('checked')){
                $payoutLink.removeClass('disable');
                $payoutLink.attr('href', $payoutRoute);
                $payoutImg.attr('src', $payoutImgSrcEnable)
            } else {
                $payoutLink.addClass('disable');
                $payoutLink.attr('href', '');
                $payoutImg.attr('src', $payoutImgSrcDisable)
            }
        });
    }


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

    /*****************************************************************************************************/
    /*                                COOKIECONSENT                                                      */
    /*****************************************************************************************************/
    window.cookieconsent_options = {
        message: "En poursuivant votre navigation sans modifier vos paramètres, vous acceptez l'utilisation des cookies" +
        " ou technologies similaires pour disposer de services er d'offres adaptés à vos centres d'interêts ainsi que" +
        " pour la sécurisation des transactions sur notre site.",
        dismiss: 'OK',
        learnMore: "Plus d'info",
        link: '/mentions-legales',
        theme: null
    };

    /*****************************************************************************************************/
    /*                                      IntroJs                                                      */
    /*****************************************************************************************************/
    $('#visite').click(function (e) {
        e.preventDefault();
        var $introJs = new introJs();
        $introJs.setOptions({
            'nextLabel': 'suivant',
            'prevLabel': 'précédent',
            'skipLabel': 'passer',
            'showStepNumbers': true,
            'showProgress': true,
            'scrollToElement': true,
            'doneLabel': 'Sortir'
        });
        $introJs.start();
    });
});