/**
 * Created by Papoun on 13/10/2015.
 */
$(function() {

    //parametre application
    var $breakPoint1 = 790;
    var $navbarMenu = $('.navbar-menu');
    var $hamburger = $('.hamburger');
    var $alerts = $('.alert');
    var $menu_links = $('.navbar-menu a');
    var $cardDescriptionP = $('.card_description p');
    var $tableaux = $('section#user div.purchase table.purchase-table, section#user div.quotation table.quotation-table');

    function setHeightHeader() {
        var $height = $(window).height();
        $('body > header').css({'height': $height})
    }

    function setHeightDivsFooter() {
        var $divs = $('body > footer div.common_footer div:not(:last)');
        var $maxheight = 0;
        $divs.each(function(){
            if ($(this).height() > $maxheight){
                $maxheight = $(this).height()
            }
        });

        $divs.each(function(){
            if ($(this).height() < $maxheight){
                $(this).css({'height': $maxheight+'px'});
            }
        });
    }

    function setFooterPosition() {
        var $footer = $('body > footer');
        $footer.removeClass('absolute');
        if($footer.offset().top+$footer.height() < $(window).height()){
            $footer.addClass('absolute');
        }
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
        var $marginTop = $window_scrollTop/4;
        $('.header-content').css({
            'opacity':$opacity,
            'margin-top': $marginTop
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

    function setcardDescriptionPSizeAndPosition() {

        var $paddingTop =  $cardDescriptionP.parent().height()/3.5+'px';
        var $fontSize = $cardDescriptionP.parent().width()/20+'px';
        var $lineHeight = $cardDescriptionP.parent().width()/10+'px';

        $cardDescriptionP.each(function() {
            $(this).css({'font-size': $fontSize});
            $(this).css({'line-height': $lineHeight});
            $(this).css({'padding-top': $paddingTop});
        });
    }

    function windowResize(){
        setHeightHeader();
        setFooterPosition();
        setcardDescriptionPSizeAndPosition();
    }


    $(document).ready(function() {
        setHeightHeader();
        setHeightDivsFooter();
        setFooterPosition();
        setcardDescriptionPSizeAndPosition();
    });

    $(window).resize(function() {
       windowResize();
    });

    $(window).scroll(function() {

        var $total_scroll = $(document).height()-$(window).height();
        var $window_scrollTop = $(window).scrollTop();
        var $rate_scroll = $window_scrollTop/$total_scroll;


        //Effacement du menu
        if(window.innerWidth <= $breakPoint1) {
            $navbarMenu.slideUp();
        }
        //adaptation de la navbar
        shrinkNavBar($window_scrollTop);

        //adaptation du fond
        setOpacityHeader($window_scrollTop);

        //definition des ancres  mettre dans l'ordre de hauteur
        var $name_ancres = ['accueil','prestations','contact','client'];
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
                $(this).trigger('click');
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
        $(this).children('.close_btn').on('click', function(){
            $(this).parent().slideUp(500, function() {
                $(this).remove();
            });
        })
    });

    //Animation des tableaux de consommation
    $tableaux.each(function(){
        $(this).children('tfoot').on('click', function() {
           $(this).parent().children('tbody').children('tr').each(function(){
              $(this).fadeToggle(600, function(){
                  windowResize();
              });
           });
           $(this).find('i').toggleClass('ion-chevron-down');
           $(this).find('i').toggleClass('ion-chevron-up');
        });
    });

});